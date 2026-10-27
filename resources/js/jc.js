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

// 13) 셀프마케팅 주문 '광고 시작하기' 4단계 (pages/self-marketing-order)
//     상품표·크레딧·라우트는 페이지에 박힌 JSON(data-jc-order-state)에서 읽는다. 상품표는 랭크프리에서 오고(GPT/Codex),
//     로컬에선 견본 상품표가 들어온다. 금액은 화면 표시용 계산이며 서버가 다시 계산해 확정한다.
document.querySelectorAll('[data-jc-order]').forEach((root) => {
    const stateEl = root.querySelector('[data-jc-order-state]');
    if (!stateEl) return;
    const cfg = JSON.parse(stateEl.textContent || '{}');
    const catalog = cfg.catalog || {};
    const $ = (sel) => root.querySelector(`[data-o="${sel}"]`);
    const main = $('main'), prevBtn = $('prev'), nextBtn = $('next'), hint = $('hint');
    const KEY = 'jc-order-draft';
    const won = (n) => `${Math.round(n).toLocaleString('ko-KR')}원`;
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const icon = (name, cls = '') => `<svg class="jc-ico ${cls}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><use href="#ji-${name}"/></svg>`;
    const DAY = ['일', '월', '화', '수', '목', '금', '토'];
    const fmtDate = (d) => `${d.getFullYear()}.${String(d.getMonth() + 1).padStart(2, '0')}.${String(d.getDate()).padStart(2, '0')}(${DAY[d.getDay()]})`;
    const range = (days) => {
        const [y, m, d] = (cfg.today || new Date().toISOString().slice(0, 10)).split('-').map(Number);
        const start = new Date(y, m - 1, d + 1); // 등록 다음 날부터
        const end = new Date(y, m - 1, d + days);
        return { start, end, text: `${fmtDate(start)} ~ ${fmtDate(end)}` };
    };

    // 상태
    let s = { type: cfg.type, step: 1, target: null, productId: null, keyword: '', qty: null, days: null, note: '', results: [] };
    try {
        const saved = JSON.parse(sessionStorage.getItem(KEY) || 'null');
        if (saved && catalog[saved.type]) s = { ...s, ...saved, results: [] };
    } catch (e) { /* 저장소를 못 쓰면 처음부터 */ }
    const save = () => { try { sessionStorage.setItem(KEY, JSON.stringify({ ...s, results: [] })); } catch (e) { /* 무시 */ } };
    const cat = () => catalog[s.type] || {};
    const products = () => cat().products || [];
    const product = () => products().find((p) => String(p.id) === String(s.productId)) || null;
    const ensureDefaults = () => {
        if (!product() && products().length) s.productId = products()[0].id;
        const p = product();
        if (p) {
            if (!s.qty || s.qty < p.qty_min || s.qty > p.qty_max) s.qty = p.qty_min;
            const days = p.days || [];
            if (!days.includes(s.days)) s.days = p.popular_days && days.includes(p.popular_days) ? p.popular_days : days[0];
        }
    };
    const total = () => { const p = product(); return p ? p.unit_price * s.qty * s.days : 0; };

    // 단계별 그리기
    const targetCard = (t, selectable = false, selected = false) => `
        <${selectable ? 'button type="button"' : 'div'} class="jc-otarget${selected ? ' is-selected' : ''}" ${selectable ? `data-o-pick="${esc(t.id)}"` : ''}>
            <span class="jc-otarget__thumb">${t.thumbnail ? `<img src="${esc(t.thumbnail)}" alt="" loading="lazy">` : icon(s.type === 'shopping' ? 'shopping' : 'store')}</span>
            <span class="jc-otarget__txt">
                <strong>${esc(t.name)}</strong>
                ${t.category ? `<span>${esc(t.category)}</span>` : ''}
                <span class="jc-otarget__tags">
                    ${t.visitor_reviews != null ? `<em class="is-blue">방문자 리뷰 ${Number(t.visitor_reviews).toLocaleString('ko-KR')}</em>` : ''}
                    ${t.blog_reviews != null ? `<em class="is-green">블로그 리뷰 ${Number(t.blog_reviews).toLocaleString('ko-KR')}</em>` : ''}
                    ${t.sample ? '<em class="is-gray">견본</em>' : ''}
                </span>
            </span>
            ${selected ? icon('check', 'jc-otarget__check') : ''}
        </${selectable ? 'button' : 'div'}>`;

    const pane1 = () => {
        const t = cat().target || {};
        return `
            <h2 class="jc-order__h">${esc(t.heading || '대상 찾기')}</h2>
            <p class="jc-order__lead">${esc(t.lead || '')}</p>
            ${t.example ? `<p class="jc-order__note">${icon('info')}<span>${esc(t.example)}</span></p>` : ''}
            <form class="jc-order__search" data-o-form="search">
                <label for="o-q">${esc(t.label || '검색어')}</label>
                <div class="jc-order__searchbox">
                    <input id="o-q" type="text" name="q" autocomplete="off" value="${esc(s.lastQuery || '')}" placeholder="${esc(t.label || '')}">
                    <button type="submit" aria-label="검색">${icon('search')}</button>
                </div>
            </form>
            <div class="jc-order__results" data-o-results>
                ${s.target && !s.results.length ? `<span class="jc-order__arrow" aria-hidden="true"></span>${targetCard(s.target, false, true)}` : ''}
                ${s.results.map((r) => targetCard(r, true, s.target && String(s.target.id) === String(r.id))).join('')}
            </div>`;
    };
    const pane2 = () => {
        const p = product() || {};
        const c = cat();
        return `
            <h2 class="jc-order__h">${icon('flag')}광고 유형</h2>
            <p class="jc-order__lead">원하는 유형을 선택하세요.</p>
            <div class="jc-oprod" role="radiogroup" aria-label="광고 유형">
                ${products().map((x) => `
                    <button type="button" role="radio" aria-checked="${String(x.id) === String(s.productId)}" data-o-prod="${esc(x.id)}" class="jc-oprod__item">
                        ${String(x.id) === String(s.productId) ? icon('check', 'jc-oprod__check') : ''}
                        ${icon(x.icon || 'spark', 'jc-oprod__ico')}
                        <strong>${esc(x.name)}</strong>
                        <em>${won(x.unit_price)}/${esc(x.unit || '회')}</em>
                    </button>`).join('')}
            </div>
            <h2 class="jc-order__h">${icon('flag')}${esc(c.keyword_label || '메인 키워드')}</h2>
            <p class="jc-order__lead">${esc(c.keyword_help || '')}</p>
            <input class="jc-order__input" type="text" maxlength="40" data-o-input="keyword" value="${esc(s.keyword)}" placeholder="${esc(c.keyword_placeholder || '')}" aria-label="${esc(c.keyword_label || '메인 키워드')}">
            <h2 class="jc-order__h">${icon('flag')}${esc(p.qty_label || '일일 목표 수량')}</h2>
            <p class="jc-order__lead">최소 ${Number(p.qty_min || 0).toLocaleString('ko-KR')}${esc(p.qty_unit || '')}부터 ${Number(p.qty_step || 1).toLocaleString('ko-KR')}${esc(p.qty_unit || '')} 단위로 조절할 수 있습니다.</p>
            <div class="jc-ostep">
                <button type="button" data-o-qty="-1" aria-label="줄이기" ${s.qty <= p.qty_min ? 'disabled' : ''}>${icon('minus')}</button>
                <output aria-live="polite"><b>${Number(s.qty).toLocaleString('ko-KR')}</b>${esc(p.qty_unit || '')}</output>
                <button type="button" data-o-qty="1" aria-label="늘리기" ${s.qty >= p.qty_max ? 'disabled' : ''}>${icon('plus')}</button>
            </div>
            ${(p.guide || []).length ? `
                <p class="jc-order__small">경쟁도별 권장 범위</p>
                <ul class="jc-oguide">${p.guide.map(([lv, txt], i) => `<li class="is-${['low', 'mid', 'high'][i] || 'low'}"><b>${esc(lv)}</b><span>${esc(txt)}</span></li>`).join('')}</ul>` : ''}
            <details class="jc-order__more" ${s.note ? 'open' : ''}>
                <summary>고객 요청사항 추가 (선택)</summary>
                <textarea maxlength="300" rows="3" data-o-input="note" placeholder="광고 진행 시 참고할 내용을 적어 주세요. (최대 300자)">${esc(s.note)}</textarea>
            </details>`;
    };
    const pane3 = () => {
        const p = product() || {};
        const r = range(s.days || 0);
        return `
            <h2 class="jc-order__h">${icon('calendar')}광고 기간</h2>
            <p class="jc-order__lead jc-order__range">${esc(r.text)}</p>
            <div class="jc-odays" role="radiogroup" aria-label="광고 기간">
                ${(p.days || []).map((d) => `
                    <button type="button" role="radio" aria-checked="${d === s.days}" data-o-days="${d}">
                        ${d === p.popular_days ? '<span class="jc-odays__badge">인기</span>' : ''}
                        <strong>${d}일</strong>${d === s.days ? icon('check') : ''}
                    </button>`).join('')}
            </div>
            <p class="jc-order__small">등록한 광고는 다음 날부터 진행됩니다.</p>`;
    };
    const pane4 = () => {
        const p = product() || {};
        const r = range(s.days || 0);
        const sum = total();
        const credit = typeof cfg.credit === 'number' ? cfg.credit : null;
        const short = credit != null ? Math.max(0, sum - credit) : 0;
        let account = '';
        if (cfg.guest) {
            account = `<div class="jc-oacct">${icon('lock')}<div><strong>주문하려면 로그인이 필요해요</strong><p>입력한 내용은 그대로 남아 있어요. 로그인 후 이 화면으로 돌아옵니다.</p></div></div>`;
        } else if (cfg.connected === false) {
            account = `<div class="jc-oacct">${icon('rankfree')}<div><strong>랭크프리 계정을 연결해 주세요</strong><p>주문은 연결한 랭크프리 계정의 크레딧으로 진행됩니다.</p><a class="jc-link" href="${esc(cfg.routes.connect)}">마이페이지에서 연결하기 →</a></div></div>`;
        } else if (credit != null) {
            account = `
                <div class="jc-ocredit${short ? ' is-short' : ''}">
                    <div><strong>보유 크레딧</strong>${short ? `<span>${icon('info')}크레딧 부족: ${won(short)}</span>` : '<span class="is-ok">바로 주문할 수 있어요</span>'}</div>
                    <b>${won(credit)}</b>
                </div>
                ${short ? (cfg.routes.charge
                    ? `<a class="jc-btn jc-btn--up jc-ocharge" href="${esc(cfg.routes.charge)}?amount=${short}">${icon('wallet')}크레딧 충전</a>`
                    : `<button type="button" class="jc-btn jc-btn--up jc-ocharge" disabled>${icon('wallet')}크레딧 충전 (연결 준비 중)</button>`) : ''}`;
        } else {
            account = `<p class="jc-order__small">보유 크레딧은 랭크프리 연동 후 이 자리에 표시됩니다.</p>`;
        }
        return `
            <h2 class="jc-order__h">${icon('flag')}${esc((cat().target || {}).noun || '대상')} 정보</h2>
            ${s.target ? targetCard(s.target, false, true) : ''}
            <h2 class="jc-order__h">${icon('flag')}광고 설정</h2>
            <dl class="jc-osum">
                <div><dt>광고 유형</dt><dd>${esc(p.name)} (${won(p.unit_price)}/${esc(p.unit || '회')})</dd></div>
                <div><dt>메인 키워드</dt><dd>${esc(s.keyword)}</dd></div>
                <div><dt>광고 기간</dt><dd><b>${s.days}일</b> <small>${esc(r.text)}</small></dd></div>
                <div><dt>${esc(p.qty_label || '일일 목표 수량')}</dt><dd>${Number(s.qty).toLocaleString('ko-KR')}${esc(p.qty_unit || '')}</dd></div>
                ${s.note ? `<div class="is-wide"><dt>요청사항</dt><dd>${esc(s.note)}</dd></div>` : ''}
            </dl>
            <h2 class="jc-order__h">${icon('flag')}비용 요약</h2>
            <div class="jc-ocost">
                <dl>
                    <div><dt>일일 비용</dt><dd>${won(p.unit_price * s.qty)}</dd></div>
                    <div><dt>광고 기간</dt><dd>${s.days}일</dd></div>
                    <div class="is-total"><dt>총 광고비</dt><dd>${won(sum)}</dd></div>
                </dl>
                ${account}
                <p class="jc-order__small">최종 금액은 주문 시 랭크프리가 다시 계산해 확정합니다.</p>
            </div>`;
    };

    const stepTitles = () => {
        const noun = (cat().target || {}).noun || '매장';
        $('step1-title').textContent = `${noun} 정보 입력`;
        $('step1-desc').textContent = `${noun}의 기본 정보를 입력하세요`;
        $('title').textContent = cat().title || '';
    };
    const canNext = () => {
        if (s.step === 1) return !!s.target;
        if (s.step === 2) return !!product() && s.keyword.trim().length > 0;
        if (s.step === 3) return !!s.days;
        return false;
    };
    const syncFoot = () => {
        prevBtn.disabled = s.step === 1;
        prevBtn.style.visibility = s.step === 1 ? 'hidden' : 'visible';
        hint.textContent = '';
        if (s.step < 4) {
            nextBtn.textContent = '다음';
            nextBtn.disabled = !canNext();
            if (s.step === 1 && !s.target) hint.textContent = `${(cat().target || {}).noun || '대상'}을 검색해서 선택해 주세요.`;
            if (s.step === 2 && !s.keyword.trim()) hint.textContent = '메인 키워드를 입력해 주세요.';
            return;
        }
        const credit = typeof cfg.credit === 'number' ? cfg.credit : null;
        if (cfg.guest) { nextBtn.textContent = '로그인하고 주문하기'; nextBtn.disabled = false; return; }
        nextBtn.textContent = '광고 생성하기';
        const ready = cfg.routes.store && cfg.connected !== false && credit != null && credit >= total();
        nextBtn.disabled = !ready;
        if (cfg.sample || !cfg.routes.store) hint.textContent = '견본 화면에서는 주문이 접수되지 않아요.';
        else if (credit != null && credit < total()) hint.textContent = '크레딧을 충전하면 바로 주문할 수 있어요.';
    };
    const render = () => {
        ensureDefaults();
        stepTitles();
        root.querySelectorAll('[data-o-type]').forEach((b) => b.setAttribute('aria-pressed', b.dataset.oType === s.type ? 'true' : 'false'));
        root.querySelectorAll('.jc-order__steps li').forEach((li) => {
            const n = Number(li.dataset.step);
            li.classList.toggle('is-done', n < s.step);
            li.classList.toggle('is-active', n === s.step);
            if (n === s.step) li.setAttribute('aria-current', 'step'); else li.removeAttribute('aria-current');
        });
        $('bar').style.width = `${(s.step / 4) * 100}%`;
        main.innerHTML = `<div class="jc-order__pane" data-pane="${s.step}">${[pane1, pane2, pane3, pane4][s.step - 1]()}</div>`;
        syncFoot();
        save();
    };
    const go = (n) => { s.step = Math.min(4, Math.max(1, n)); render(); main.scrollTop = 0; const top = root.getBoundingClientRect().top; if (top < 0) root.scrollIntoView({ block: 'start', behavior: jcReduce ? 'auto' : 'smooth' }); };

    // 검색: 실제 검색 라우트가 있으면 서버(GPT/Codex)에, 없으면(견본) 입력값으로 카드를 만든다
    const search = async (q) => {
        s.lastQuery = q;
        if (!q) return;
        hint.textContent = '찾는 중…';
        if (cfg.routes.search) {
            try {
                const res = await fetch(`${cfg.routes.search}?type=${encodeURIComponent(s.type)}&q=${encodeURIComponent(q)}`, { headers: { Accept: 'application/json' }, credentials: 'same-origin' });
                const json = await res.json();
                s.results = Array.isArray(json.data) ? json.data : [];
            } catch (e) { s.results = []; }
            if (!s.results.length) { render(); hint.textContent = '검색 결과가 없어요. 이름 대신 URL로 다시 찾아보세요.'; return; }
        } else {
            const id = (q.match(/(?:place|products)\/(\d+)/) || [])[1];
            s.results = [{ id: id || `sample-${Date.now()}`, name: id ? `${s.type === 'shopping' ? '상품' : '플레이스'} #${id}` : q, category: '매장·상품 정보는 검색 연결 후 표시', sample: true }];
        }
        if (s.results.length === 1) s.target = s.results[0];
        render();
    };

    root.addEventListener('submit', (e) => {
        if (!e.target.matches('[data-o-form="search"]')) return;
        e.preventDefault();
        search(e.target.querySelector('input').value.trim());
    });
    root.addEventListener('click', (e) => {
        const t = e.target.closest('[data-o-type],[data-o-pick],[data-o-prod],[data-o-qty],[data-o-days]');
        if (!t) return;
        if (t.dataset.oType && t.dataset.oType !== s.type) {
            s = { ...s, type: t.dataset.oType, step: 1, target: null, productId: null, qty: null, days: null, results: [], lastQuery: '' };
            render();
        } else if (t.dataset.oPick) {
            s.target = s.results.find((r) => String(r.id) === t.dataset.oPick) || null; render();
        } else if (t.dataset.oProd) {
            s.productId = t.dataset.oProd; s.qty = null; render();
        } else if (t.dataset.oQty) {
            const p = product(); if (!p) return;
            s.qty = Math.min(p.qty_max, Math.max(p.qty_min, s.qty + Number(t.dataset.oQty) * p.qty_step)); render();
        } else if (t.dataset.oDays) {
            s.days = Number(t.dataset.oDays); render();
        }
    });
    root.addEventListener('input', (e) => {
        const f = e.target.dataset.oInput;
        if (!f) return;
        s[f] = e.target.value;
        save();
        syncFoot();
    });
    prevBtn.addEventListener('click', () => go(s.step - 1));
    nextBtn.addEventListener('click', async () => {
        if (s.step < 4) { if (canNext()) go(s.step + 1); return; }
        if (cfg.guest) {
            save();
            const back = `${cfg.routes.self}?type=${encodeURIComponent(s.type)}`;
            location.href = `${cfg.routes.login}?redirect=${encodeURIComponent(back)}`;
            return;
        }
        if (nextBtn.disabled || !cfg.routes.store) return;
        nextBtn.disabled = true;
        hint.textContent = '주문을 접수하는 중…';
        try {
            const res = await fetch(cfg.routes.store, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ type: s.type, product_id: s.productId, target_id: s.target?.id, target_url: s.target?.url || null, keyword: s.keyword.trim(), daily_quantity: s.qty, days: s.days, note: s.note.trim() || null }),
            });
            const json = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(json?.error?.message || '주문을 접수하지 못했어요. 잠시 후 다시 시도해 주세요.');
            try { sessionStorage.removeItem(KEY); } catch (e) { /* 무시 */ }
            location.href = json?.data?.redirect || cfg.routes.orders || cfg.routes.self;
        } catch (err) {
            hint.textContent = err.message;
            nextBtn.disabled = false;
        }
    });

    // 로그인하고 돌아왔으면 마지막 단계부터
    if (!cfg.guest && s.step === 4 && s.target) { /* 그대로 4단계 */ } else if (s.step > 1 && !s.target) s.step = 1;
    render();
});
