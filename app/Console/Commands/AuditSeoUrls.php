<?php

namespace App\Console\Commands;

use App\Services\Seo\Publishing\UrlAuditManifest;
use App\Services\Seo\Publishing\UrlAuditor;
use Illuminate\Console\Command;
use InvalidArgumentException;

class AuditSeoUrls extends Command
{
    protected $signature = 'seo:audit-urls {--base-url= : Explicit HTTP(S) origin to inspect} {--manifest= : Approved JSON expectation list} {--json : Print the complete report as JSON}';

    protected $description = 'Check existing URL preservation without changing routes, content or redirect mappings';

    public function handle(UrlAuditManifest $manifest, UrlAuditor $auditor): int
    {
        if (! is_string($this->option('base-url')) || $this->option('base-url') === '') {
            $this->error('Specify --base-url explicitly; no server is contacted by default.');

            return self::INVALID;
        }
        try {
            $report = $auditor->audit($manifest->load($this->option('manifest')), $this->option('base-url'));
        } catch (InvalidArgumentException $e) {
            $this->error($e->getMessage());

            return self::INVALID;
        }

        if ($this->option('json')) {
            $this->line(json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $this->table(['Path', 'Expected', 'Observed', 'Result'], array_map(fn ($row) => [
                $row['path'], $row['expected_status'], $row['observed_status'] ?? '-',
                $row['passed'] ? 'PASS' : implode(', ', $row['issues']),
            ], $report['results']));
            $this->line("Total {$report['total']}; passed {$report['passed']}; failed {$report['failed']}");
        }

        return $report['failed'] === 0 ? self::SUCCESS : self::FAILURE;
    }
}
