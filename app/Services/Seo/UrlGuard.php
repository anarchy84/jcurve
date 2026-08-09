<?php

namespace App\Services\Seo;

/**
 * SSRF 방어 — 방문자가 입력한 URL을 서버가 fetch 하기 전 검증한다.
 * 공인(public) http/https URL만 허용하고, 내부망·루프백·링크로컬·클라우드
 * 메타데이터 대역을 차단한다. DNS 리바인딩 대비로 "검증에 쓴 IP"를 함께 돌려줘
 * fetch 단계에서 그 IP로 고정 접속하도록 한다.
 */
class UrlGuard
{
    /** 차단 CIDR (IPv4/IPv6 주요 사설·특수 대역) */
    private const BLOCKED = [
        '0.0.0.0/8', '10.0.0.0/8', '100.64.0.0/10', '127.0.0.0/8',
        '169.254.0.0/16', '172.16.0.0/12', '192.0.0.0/24', '192.0.2.0/24',
        '192.168.0.0/16', '198.18.0.0/15', '198.51.100.0/24', '203.0.113.0/24',
        '224.0.0.0/4', '240.0.0.0/4', '255.255.255.255/32',
        '::1/128', 'fc00::/7', 'fe80::/10', '::/128',
        // IPv4-mapped / 변환 대역 — PHP 버전 의존 없이 명시 차단
        '::ffff:0:0/96', '64:ff9b::/96', '2002::/16', '100::/64',
    ];

    /**
     * @return array{ok:bool, url?:string, host?:string, ip?:string, error?:string}
     */
    public function validate(string $input): array
    {
        $input = trim($input);
        if ($input === '') {
            return ['ok' => false, 'error' => 'URL을 입력해 주세요.'];
        }
        // 스킴 없으면 https 보정
        if (! preg_match('#^https?://#i', $input)) {
            $input = 'https://'.$input;
        }
        $parts = parse_url($input);
        if ($parts === false || empty($parts['host'])) {
            return ['ok' => false, 'error' => '올바른 URL 형식이 아닙니다.'];
        }
        $scheme = strtolower($parts['scheme'] ?? '');
        if (! in_array($scheme, ['http', 'https'], true)) {
            return ['ok' => false, 'error' => 'http/https 주소만 분석할 수 있습니다.'];
        }
        $host = $parts['host'];
        // 사용자/비표준 포트 차단(80/443만)
        $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
        if (! in_array((int) $port, [80, 443], true)) {
            return ['ok' => false, 'error' => '표준 포트(80/443)만 허용됩니다.'];
        }
        // 호스트를 IP로 해석 (모든 A/AAAA 검사 — 하나라도 사설이면 차단)
        $ips = $this->resolve($host);
        if (empty($ips)) {
            return ['ok' => false, 'error' => '도메인을 확인할 수 없습니다.'];
        }
        foreach ($ips as $ip) {
            if ($this->isBlocked($ip)) {
                return ['ok' => false, 'error' => '내부/사설 네트워크 주소는 분석할 수 없습니다.'];
            }
        }
        // 정규화된 URL(포트는 80/443만 허용되므로 생략) + 고정 IP 반환
        $normalized = $scheme.'://'.$host
            .($parts['path'] ?? '/').(isset($parts['query']) ? '?'.$parts['query'] : '');

        return ['ok' => true, 'url' => $normalized, 'host' => $host, 'ip' => $ips[0]];
    }

    /** @return string[] */
    private function resolve(string $host): array
    {
        // 이미 IP 리터럴이면 그대로
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return [$host];
        }
        $ips = [];
        $a = @dns_get_record($host, DNS_A);
        foreach ($a ?: [] as $r) {
            if (! empty($r['ip'])) $ips[] = $r['ip'];
        }
        $aaaa = @dns_get_record($host, DNS_AAAA);
        foreach ($aaaa ?: [] as $r) {
            if (! empty($r['ipv6'])) $ips[] = $r['ipv6'];
        }
        // 폴백: gethostbyname (IPv4)
        if (empty($ips)) {
            $ip = gethostbyname($host);
            if ($ip !== $host) $ips[] = $ip;
        }
        return array_values(array_unique($ips));
    }

    private function isBlocked(string $ip): bool
    {
        // IPv4-mapped(::ffff:)/NAT64(64:ff9b::) 등은 내장 IPv4로 환산해 재검사
        // — PHP 런타임의 예약대역 판정에 의존하지 않도록.
        $mapped = $this->extractMappedV4($ip);
        if ($mapped !== null && $mapped !== $ip && $this->isBlocked($mapped)) {
            return true;
        }
        // 공인 범위가 아니면(사설/예약) 차단
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }
        foreach (self::BLOCKED as $cidr) {
            if ($this->inCidr($ip, $cidr)) return true;
        }
        return false;
    }

    /** IPv6에 내장된 IPv4(::ffff:a.b.c.d / 64:ff9b::a.b.c.d)를 뽑아낸다. */
    private function extractMappedV4(string $ip): ?string
    {
        $bin = @inet_pton($ip);
        if ($bin === false || strlen($bin) !== 16) return null;
        $prefixes = [
            "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff", // ::ffff:0:0/96
            @inet_pton('64:ff9b::') ?: '',                        // 64:ff9b::/96
        ];
        foreach ($prefixes as $pfx) {
            if ($pfx !== '' && strncmp($bin, $pfx, 12) === 0) {
                $v4 = @inet_ntop(substr($bin, 12, 4));
                return $v4 === false ? null : $v4;
            }
        }
        return null;
    }

    private function inCidr(string $ip, string $cidr): bool
    {
        [$subnet, $bits] = array_pad(explode('/', $cidr, 2), 2, null);
        $bits = (int) $bits;
        $ipBin = @inet_pton($ip);
        $subBin = @inet_pton($subnet);
        if ($ipBin === false || $subBin === false || strlen($ipBin) !== strlen($subBin)) {
            return false;
        }
        $bytes = intdiv($bits, 8);
        $rem = $bits % 8;
        if ($bytes && strncmp($ipBin, $subBin, $bytes) !== 0) {
            return false;
        }
        if ($rem) {
            $mask = chr(0xFF << (8 - $rem) & 0xFF);
            return (($ipBin[$bytes] & $mask) === ($subBin[$bytes] & $mask));
        }
        return true;
    }
}
