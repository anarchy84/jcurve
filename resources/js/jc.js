/*
 * 제이커브 리뉴얼 화면 스크립트 (Claude 구역)
 * - 순위 확인 폼: 플레이스/쇼핑/블로그 토글 + 랭크프리로 이동
 * - 인사이트 상세: 본문 소제목으로 목차 자동 생성 + 현재 위치 표시
 * - 모바일 메뉴: 링크 누르면 닫기
 * 서버 데이터가 필요한 기능은 없다. 전부 화면 안에서만 동작한다.
 */

// 1) 세그먼트 토글: aria-pressed 상태를 바꾸고, 같은 폼의 hidden input 값을 맞춘다.
document.querySelectorAll('[data-jc-seg]').forEach((group) => {
    const target = group.closest('form')?.querySelector('input[name="area"]');
    group.querySelectorAll('button[data-value]').forEach((button) => {
        button.addEventListener('click', () => {
            group.querySelectorAll('button[data-value]').forEach((b) => b.setAttribute('aria-pressed', 'false'));
            button.setAttribute('aria-pressed', 'true');
            if (target) target.value = button.dataset.value;
        });
    });
});

// 2) 순위 확인 폼: 사이트 안에서 받지 않고 랭크프리 무료 순위 확인으로 보낸다.
//    랭크프리 검색 파라미터 이름은 아직 확정 전(COLLAB §3 제안). 확정되면 아래 두 줄만 바꾼다.
const RANKFREE_URL = 'https://rankfree.kr';
document.querySelectorAll('form[data-jc-rankcheck]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const keyword = form.querySelector('input[name="keyword"]')?.value.trim() || '';
        const area = form.querySelector('input[name="area"]')?.value || 'place';
        const url = new URL(RANKFREE_URL);
        if (keyword) url.searchParams.set('keyword', keyword);
        url.searchParams.set('area', area);
        window.open(url.toString(), '_blank', 'noopener');
    });
});

// 3) 인사이트 목차: .jc-prose 안의 h2/h3로 만든다. 소제목이 2개 미만이면 목차 자리를 숨긴다.
const prose = document.querySelector('[data-jc-prose]');
const toc = document.querySelector('[data-jc-toc]');
if (prose) {
    // 이식 원문(WP Avada) 이미지는 srcset에 빈 SVG 자리표시가 들어 있어 그대로 두면 그림이 안 보인다.
    // 진짜 srcset(data-srcset)이 있으면 복구하고, 없으면 srcset을 지워 src를 쓰게 한다. (원문 정리는 QUEUE Q-013)
    prose.querySelectorAll('img').forEach((img) => {
        const srcset = img.getAttribute('srcset') || '';
        if (srcset.startsWith('data:')) {
            const real = img.getAttribute('data-srcset');
            if (real) img.setAttribute('srcset', real);
            else img.removeAttribute('srcset');
        }
        if (!img.hasAttribute('fetchpriority')) img.loading = 'lazy';
    });
}
if (prose && toc) {
    const all = [...prose.querySelectorAll('h2, h3')].filter((h) => h.textContent.trim().length > 0);
    // 큰 소제목(h2)이 3개 이상이면 h2만 써서 목차를 짧게 유지한다.
    const h2s = all.filter((h) => h.tagName === 'H2');
    const headings = h2s.length >= 3 ? h2s : all;
    if (headings.length < 2) {
        toc.hidden = true;
    } else {
        const list = toc.querySelector('ol');
        headings.forEach((h, index) => {
            if (!h.id) h.id = `section-${index + 1}`;
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = `#${h.id}`;
            a.textContent = h.textContent.trim();
            if (h.tagName === 'H3') a.style.paddingLeft = '28px';
            li.appendChild(a);
            list.appendChild(li);
        });
        const links = [...list.querySelectorAll('a')];
        const mark = (id) => links.forEach((a) => a.setAttribute('aria-current', a.hash === `#${id}` ? 'true' : 'false'));
        mark(headings[0].id);
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.filter((e) => e.isIntersecting).forEach((e) => mark(e.target.id));
            }, { rootMargin: '-20% 0px -70% 0px' });
            headings.forEach((h) => observer.observe(h));
        }
    }
}

// 4) 모바일 메뉴: 링크를 누르면 패널을 닫는다.
document.querySelectorAll('.jc-mnav').forEach((details) => {
    details.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => details.removeAttribute('open')));
});

// 5) 홈 '목표별 서비스' 필터: 버튼을 누르면 해당 목표의 카드만 보인다. (기존 v1 Alpine 필터를 대체)
document.querySelectorAll('[data-jc-goals]').forEach((box) => {
    const buttons = [...box.querySelectorAll('[data-goal]')];
    const cards = [...box.querySelectorAll('[data-goals]')];
    buttons.forEach((btn) => btn.addEventListener('click', () => {
        const goal = btn.dataset.goal;
        buttons.forEach((b) => b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'));
        cards.forEach((card) => {
            card.hidden = goal !== 'all' && !card.dataset.goals.split('|').includes(goal);
        });
    }));
});
