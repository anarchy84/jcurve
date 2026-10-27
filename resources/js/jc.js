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

const jcReduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const jcInView = (el) => {
    const r = el.getBoundingClientRect();
    return r.top < window.innerHeight && r.bottom > 0;
};

// 6) 숫자 카운트업: 화면에 들어오는 순간 0 → 최종값으로 빠르게 올라간다.
//    원문(HTML)에는 최종 숫자가 그대로 있어 검색엔진·보조기기에는 영향이 없다. v1의 [data-count-to](gsap)는 건드리지 않는다.
const jcCountTargets = document.querySelectorAll(
    '.jc-site :is(.jc-stat__num, .jc-why__num, .jc-board .jc-num, .jc-plans .jc-num, .jc-work__metric), .jc-legacy .detail__metric strong'
);
const jcFormat = (value, decimals, comma) => {
    const fixed = value.toFixed(decimals);
    if (!comma) return fixed;
    const [int, dec] = fixed.split('.');
    return int.replace(/\B(?=(\d{3})+(?!\d))/g, ',') + (dec ? `.${dec}` : '');
};
// 숫자 마디를 찾아 카운트업 준비(0으로 바꿔 둠). 준비되면 true.
const jcPrepCount = (el) => {
    if (el.jcCount) return true;
    if (el.closest('[data-count-to]') || el.hasAttribute('data-count-to')) return false;
    // 숫자가 든 첫 글자 마디만 바꾼다(뒤의 <small> 라벨 등은 그대로)
    const node = [...el.childNodes].find((n) => n.nodeType === 3 && /\d/.test(n.nodeValue));
    if (!node) return false;
    const m = node.nodeValue.match(/^(\D*?)(\d[\d,]*(?:\.\d+)?)([\s\S]*)$/);
    if (!m) return false;
    const raw = m[2];
    const target = parseFloat(raw.replace(/,/g, ''));
    if (!isFinite(target) || target === 0) return false;
    el.jcCount = { node, prefix: m[1], suffix: m[3], target, decimals: (raw.split('.')[1] || '').length, comma: raw.includes(',') || target >= 10000 };
    node.nodeValue = m[1] + jcFormat(0, el.jcCount.decimals, el.jcCount.comma) + m[3];
    return true;
};
// 0에서 최종값까지 올린다. 다시 부르면 처음부터 다시 센다(첫 화면 전환 패널용).
const jcCount = (el, delay = 0) => {
    const { prefix, suffix, target, decimals, comma, node } = el.jcCount;
    const run = (el.jcRun = (el.jcRun || 0) + 1);
    const duration = 1700;
    node.nodeValue = prefix + jcFormat(0, decimals, comma) + suffix;
    el.setAttribute('data-jc-counting', '');
    setTimeout(() => {
        const start = performance.now();
        const tick = (now) => {
            if (el.jcRun !== run) return;
            const t = Math.min(1, (now - start) / duration);
            const eased = t === 1 ? 1 : 1 - Math.pow(2, -10 * t); // 처음엔 후루룩, 끝에서 사뿐히 멈춤
            node.nodeValue = prefix + jcFormat(target * eased, decimals, comma) + suffix;
            if (t < 1) requestAnimationFrame(tick);
            else el.removeAttribute('data-jc-counting');
        };
        requestAnimationFrame(tick);
    }, delay);
};
if (!jcReduce && 'IntersectionObserver' in window) {
    const countObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            countObserver.unobserve(entry.target);
            jcCount(entry.target);
        });
    }, { threshold: 0.4 });
    jcCountTargets.forEach((el) => {
        if (jcPrepCount(el)) countObserver.observe(el);
    });
}

// 7) 스크롤 등장: 첫 화면 아래의 카드·칸들이 차례로 떠오른다.
if (!jcReduce && 'IntersectionObserver' in window) {
    const revealSelector = [
        '.jc-section .jc-head', '.jc-biz__col', '.jc-goal', '.jc-door', '.jc-why__item', '.jc-product', '.jc-stat',
        '.jc-layer', '.jc-apps li', '.jc-post', '.jc-work', '.jc-split > div', '.jc-index > div', '.jc-order-steps li',
        '.jc-three > div', '.jc-bigsteps li', '.jc-promise > div', '.jc-read > div', '.jc-plans > div', '.jc-trust',
    ].map((s) => `.jc-site ${s}`).join(',');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-in');
            revealObserver.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
    document.querySelectorAll(revealSelector).forEach((el) => {
        if (jcInView(el)) return; // 처음부터 보이는 건 숨기지 않는다
        const siblings = [...el.parentElement.children];
        el.style.setProperty('--jc-i', String(siblings.indexOf(el) % 6));
        el.classList.add('jc-reveal');
        revealObserver.observe(el);
    });
}

// 8) 첫 화면 입자: 파란 빛 입자가 곡선 방향(오른쪽 위)으로 천천히 떠오른다. 화면 밖이거나 탭이 숨겨지면 멈춘다.
document.querySelectorAll('[data-jc-particles]').forEach((canvas) => {
    if (jcReduce) return;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;
    let width = 0, height = 0, dpr = 1, running = false, raf = 0;
    const particles = [];
    const resize = () => {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = canvas.clientWidth; height = canvas.clientHeight;
        canvas.width = width * dpr; canvas.height = height * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };
    const spawn = (initial) => {
        const x = Math.random() * width;
        return {
            x, y: initial ? Math.random() * height : height + 10,
            r: Math.random() * 1.6 + 0.4,
            vx: 0.08 + Math.random() * 0.22, vy: -(0.18 + Math.random() * 0.45),
            a: 0, max: 0.25 + Math.random() * 0.55, life: 0, span: 420 + Math.random() * 520,
        };
    };
    const count = () => Math.round(Math.min(70, Math.max(24, width / 22)));
    const frame = () => {
        ctx.clearRect(0, 0, width, height);
        while (particles.length < count()) particles.push(spawn(particles.length < count() / 2));
        particles.forEach((p, i) => {
            p.life += 1; p.x += p.vx; p.y += p.vy;
            const t = p.life / p.span;
            p.a = p.max * Math.sin(Math.min(1, t) * Math.PI);
            if (t >= 1 || p.y < -10 || p.x > width + 10) particles[i] = spawn(false);
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(143,160,255,${p.a.toFixed(3)})`;
            ctx.fill();
        });
        raf = requestAnimationFrame(frame);
    };
    const start = () => { if (!running) { running = true; raf = requestAnimationFrame(frame); } };
    const stop = () => { running = false; cancelAnimationFrame(raf); };
    resize();
    window.addEventListener('resize', resize, { passive: true });
    new IntersectionObserver(([e]) => (e.isIntersecting ? start() : stop())).observe(canvas);
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : jcInView(canvas) && start()));
});

// 9) 첫 화면 오른쪽 전환 패널: 숫자로 증명 → 내 순위 확인 → 바로 시작을 7초마다 넘긴다.
//    - 탭 아래 막대(CSS 애니메이션)가 다 차면 다음 장. 마우스를 올리거나 키보드로 들어가거나 화면 밖이면 멈춘다.
//    - 탭을 직접 누르거나, 넘기거나(손가락), 순위 확인 칸에 입력하면 자동 넘김을 끈다(사용자가 고른 화면을 존중).
//    - 움직임 줄이기 설정이면 자동 넘김 없이 탭으로만 바꾼다.
document.querySelectorAll('[data-jc-hx]').forEach((root) => {
    const tabs = [...root.querySelectorAll('[role="tab"]')];
    const panels = [...root.querySelectorAll('[role="tabpanel"]')];
    if (tabs.length < 2 || tabs.length !== panels.length) return;
    let index = Math.max(0, tabs.findIndex((t) => t.getAttribute('aria-selected') === 'true'));
    const holds = new Set();
    const sync = () => root.classList.toggle('is-paused', holds.size > 0);
    const hold = (why, on) => { on ? holds.add(why) : holds.delete(why); sync(); };
    const stop = () => root.classList.add('is-stopped');
    if (jcReduce) stop();

    const countIn = (panel) => {
        if (jcReduce) return;
        panel.querySelectorAll('.jc-hx__num').forEach((el) => {
            if (jcPrepCount(el)) jcCount(el, Number(el.dataset.jcDelay || 0)); // 기록점 카드가 켜지는 순서에 맞춰 센다
        });
    };
    const show = (next, { focus = false } = {}) => {
        index = (next + panels.length) % panels.length;
        tabs.forEach((tab, i) => {
            const on = i === index;
            tab.classList.toggle('is-active', on);
            tab.setAttribute('aria-selected', on ? 'true' : 'false');
            tab.tabIndex = on ? 0 : -1;
        });
        panels.forEach((panel, i) => panel.classList.toggle('is-active', i === index));
        if (focus) tabs[index].focus();
        countIn(panels[index]);
    };

    // 막대가 다 차면 다음 장
    tabs.forEach((tab) => tab.querySelector('.jc-hx__bar i')?.addEventListener('animationend', () => {
        if (!root.classList.contains('is-stopped') && tab.classList.contains('is-active')) show(index + 1);
    }));
    // 직접 고르기: 클릭·방향키
    tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => { stop(); if (i !== index) show(i); });
        tab.addEventListener('keydown', (e) => {
            const move = { ArrowRight: 1, ArrowLeft: -1, Home: -index, End: tabs.length - 1 - index }[e.key];
            if (move === undefined) return;
            e.preventDefault(); stop(); show(index + move, { focus: true });
        });
    });
    // 멈춤: 마우스 올림 · 키보드 포커스 · 화면 밖 · 탭 숨김
    root.addEventListener('pointerenter', (e) => { if (e.pointerType === 'mouse') hold('hover', true); });
    root.addEventListener('pointerleave', (e) => { if (e.pointerType === 'mouse') hold('hover', false); });
    root.addEventListener('focusin', (e) => { hold('focus', true); if (e.target.matches('input, select, textarea')) stop(); });
    root.addEventListener('focusout', () => setTimeout(() => hold('focus', root.matches(':focus-within')), 0));
    root.addEventListener('input', stop);
    if ('IntersectionObserver' in window) new IntersectionObserver(([e]) => hold('offscreen', !e.isIntersecting)).observe(root);
    document.addEventListener('visibilitychange', () => hold('hidden', document.hidden));
    // 손가락으로 좌우 넘기기
    const stage = root.querySelector('[data-jc-hx-stage]');
    let startX = null, startY = 0;
    stage?.addEventListener('pointerdown', (e) => { if (e.pointerType !== 'mouse') { startX = e.clientX; startY = e.clientY; } });
    stage?.addEventListener('pointerup', (e) => {
        if (startX === null) return;
        const dx = e.clientX - startX, dy = e.clientY - startY;
        startX = null;
        if (Math.abs(dx) > 48 && Math.abs(dx) > Math.abs(dy) * 1.5) { stop(); show(index + (dx < 0 ? 1 : -1)); }
    });
    stage?.addEventListener('pointercancel', () => { startX = null; });

    countIn(panels[index]);
});

// 10) 홈 매대: 마케팅 서비스 항목을 누르면 상세가 열린다.
//     데스크톱 — 셀프마케팅·운영 서비스가 오른쪽으로 비켜나고 그 자리에 상세. 빈 곳이나 비켜난 칸을 누르면 원래대로.
//     태블릿·모바일 — 누른 항목 바로 아래로 상세가 펼쳐진다. 같은 항목을 다시 누르면 접힌다.
//     스크립트가 없으면 항목이 그냥 서비스 페이지 링크로 동작한다.
document.querySelectorAll('[data-jc-biz]').forEach((biz) => {
    const items = [...biz.querySelectorAll('[data-jc-biz-item]')];
    const rest = biz.querySelector('[data-jc-biz-rest]');
    const wide = window.matchMedia('(min-width: 1081px)');
    let current = null;
    const open = (item) => {
        items.forEach((it) => it.setAttribute('aria-expanded', it === item ? 'true' : 'false'));
        current = item;
        biz.classList.add('is-open');
    };
    const close = ({ focus = false } = {}) => {
        if (!current) return;
        const was = current;
        items.forEach((it) => it.setAttribute('aria-expanded', 'false'));
        current = null;
        biz.classList.remove('is-open');
        if (focus) was.focus();
    };
    items.forEach((item) => item.addEventListener('click', (e) => {
        e.preventDefault();
        if (current === item) close();
        else open(item);
    }));
    biz.querySelectorAll('[data-jc-biz-close]').forEach((btn) => btn.addEventListener('click', () => close({ focus: true })));
    // 비켜난 셀프마케팅·운영 서비스를 누르면 이동하지 않고 원래 자리로 돌아온다(데스크톱).
    rest?.addEventListener('click', (e) => {
        if (!current || !wide.matches) return;
        e.preventDefault();
        e.stopPropagation();
        close();
    }, true);
    // 빈 곳을 누르면 원래대로
    document.addEventListener('click', (e) => {
        if (!current || e.target.closest('.jc-biz__detail, [data-jc-biz-item]')) return;
        close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && current) close({ focus: true });
    });
});

// 11) 운영 중인 앱: 좌우 버튼으로 한 장씩 넘긴다. 끝에 닿으면 해당 버튼을 끈다.
document.querySelectorAll('[data-jc-apps-nav]').forEach((nav) => {
    const list = nav.closest('section')?.querySelector('[data-jc-apps]');
    if (!list) return;
    const [prev, next] = [...nav.querySelectorAll('button[data-dir]')];
    const step = () => {
        const first = list.children[0];
        const gap = parseFloat(getComputedStyle(list).columnGap) || 0;
        return first ? first.getBoundingClientRect().width + gap : list.clientWidth * 0.8;
    };
    const sync = () => {
        const max = list.scrollWidth - list.clientWidth - 2;
        prev.disabled = list.scrollLeft <= 2;
        next.disabled = list.scrollLeft >= max;
        nav.hidden = max <= 0; // 다 보이면 버튼 숨김
    };
    nav.querySelectorAll('button[data-dir]').forEach((btn) => btn.addEventListener('click', () => {
        list.scrollBy({ left: step() * Number(btn.dataset.dir), behavior: jcReduce ? 'auto' : 'smooth' });
    }));
    list.addEventListener('scroll', () => requestAnimationFrame(sync), { passive: true });
    window.addEventListener('resize', sync, { passive: true });
    sync();
});

// 12) 고객센터 자주 묻는 질문: 왼쪽 분야로 거르고, 검색칸으로 전체에서 찾는다(찾은 단어 표시).
document.querySelectorAll('[data-jc-faq]').forEach((hub) => {
    const buttons = [...hub.querySelectorAll('[data-cat]')];
    const groups = [...hub.querySelectorAll('[data-group]')];
    const items = [...hub.querySelectorAll('.jc-faqhub__item')].map((el) => {
        const summary = el.querySelector('.jc-faqhub__q') || el.querySelector('summary');
        const answer = el.querySelector('.jc-faqhub__a p');
        return { el, summary, answer, q: summary.textContent, a: answer.textContent };
    });
    const input = document.querySelector('[data-jc-faq-search]');
    const count = document.querySelector('[data-jc-faq-count]');
    const empty = hub.querySelector('[data-jc-faq-empty]');
    const termOut = hub.querySelector('[data-jc-faq-term]');
    const total = items.length;
    const escapeHtml = (s) => s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const mark = (text, terms) => {
        let out = escapeHtml(text);
        terms.forEach((t) => {
            const re = new RegExp(escapeHtml(t).replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
            out = out.replace(re, (m) => `<mark>${m}</mark>`);
        });
        return out;
    };
    const press = (cat) => buttons.forEach((b) => b.setAttribute('aria-pressed', b.dataset.cat === cat ? 'true' : 'false'));
    const showCategory = (cat) => {
        press(cat);
        groups.forEach((g) => { g.hidden = cat !== 'all' && g.dataset.group !== cat; });
        items.forEach((it) => { it.el.hidden = false; it.summary.textContent = it.q; it.answer.textContent = it.a; });
        if (empty) empty.hidden = true;
        const n = cat === 'all' ? total : hub.querySelectorAll(`[data-group="${cat}"] .jc-faqhub__item`).length;
        if (count) count.textContent = `질문 ${n}개`;
    };
    const search = (value) => {
        const terms = value.trim().toLowerCase().split(/\s+/).filter(Boolean);
        if (!terms.length) { showCategory('all'); return; }
        press('all');
        let found = 0;
        items.forEach((it) => {
            const hay = `${it.q} ${it.a}`.toLowerCase();
            const hit = terms.every((t) => hay.includes(t));
            it.el.hidden = !hit;
            if (hit) {
                found += 1;
                it.summary.innerHTML = mark(it.q, terms);
                it.answer.innerHTML = mark(it.a, terms);
            }
        });
        groups.forEach((g) => { g.hidden = !g.querySelector('.jc-faqhub__item:not([hidden])'); });
        if (found > 0 && found <= 3) items.filter((it) => !it.el.hidden).forEach((it) => { it.el.open = true; });
        if (empty) { empty.hidden = found > 0; if (termOut) termOut.textContent = value.trim(); }
        if (count) count.textContent = `검색 결과 ${found}개`;
    };
    buttons.forEach((b) => b.addEventListener('click', () => {
        if (input) input.value = '';
        showCategory(b.dataset.cat);
        if (!window.matchMedia('(min-width: 1081px)').matches) hub.scrollIntoView({ behavior: jcReduce ? 'auto' : 'smooth', block: 'start' });
    }));
    let timer = 0;
    input?.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(() => search(input.value), 120); });
    // 주소 끝에 #faq-ads 처럼 분야가 붙어 오면 그 분야부터 보여준다
    const fromHash = location.hash.replace('#faq-', '');
    if (fromHash && buttons.some((b) => b.dataset.cat === fromHash)) showCategory(fromHash);
});
