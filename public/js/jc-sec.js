/* 11/06 섹션 다시 꾸미기 (TASK-1455, 대표님 14:50~15:08).
   「선 + 글」 칸 → 테두리 카드(가운데 작은 그림 + 굵은 제목 + 짧은 설명), 단계 → 번호 도식,
   줄글 → 문단 카드, 체크 목록 → 체크 카드, 숫자 → 숫자 카드, 쪽 안 메뉴 → 큰 탭 줄.
   뜻 없는 장식 그림(곡선·깃발 등)은 쓰지 않는다. 큰 그림은 쪽 주제 화면 모양일 때만(히어로).
   글·숫자는 페이지에 있는 것만 쓴다. 그림은 aria-hidden. 스타일 public/css/jc-sec.css */
(function () {
  'use strict';
  var NS = 'http://www.w3.org/2000/svg';
  var PATH = decodeURIComponent(location.pathname);

  /* ---------- 큰 그림(장면) : viewBox 0 0 360 240 ---------- */
  function card(x, y, w, h, r) { return '<rect class="c-w s-ln" x="' + x + '" y="' + y + '" width="' + w + '" height="' + h + '" rx="' + (r || 12) + '"/>'; }
  function bar(x, y, w, h, c) { return '<rect class="' + (c || 'c-g') + '" x="' + x + '" y="' + y + '" width="' + w + '" height="' + (h || 7) + '" rx="' + Math.min(4, (h || 7) / 2) + '"/>'; }
  var BG = '<rect class="c-bg" x="0" y="0" width="360" height="240" rx="20"/>';

  var SCENES = {
    report: function () {
      var s = BG + card(22, 24, 232, 192) + bar(40, 42, 86, 9, 'c-ink') + bar(40, 58, 52, 6);
      var hs = [38, 60, 48, 82, 70, 108], pts = [];
      for (var i = 0; i < 6; i++) {
        var x = 46 + i * 33, y = 196 - hs[i];
        s += '<rect class="' + (i > 3 ? 'c-p' : 'c-t') + '" x="' + x + '" y="' + y + '" width="20" height="' + hs[i] + '" rx="4"/>';
        pts.push((x + 10) + ',' + (y - 14));
      }
      s += '<line class="s-ln" x1="38" y1="196" x2="238" y2="196"/>';
      s += '<polyline class="s-p" stroke-width="3" points="' + pts.join(' ') + '"/>';
      pts.forEach(function (p) { var a = p.split(','); s += '<circle class="c-w s-p" stroke-width="2.5" cx="' + a[0] + '" cy="' + a[1] + '" r="4"/>'; });
      s += card(266, 30, 74, 56, 10) + bar(278, 44, 34, 9, 'c-p') + bar(278, 62, 48, 6);
      s += card(266, 96, 74, 56, 10) + '<polyline class="s-ok" stroke-width="3" points="280,136 294,122 304,130 324,108"/><polyline class="s-ok" stroke-width="3" points="316,108 324,108 324,116"/>';
      s += card(266, 162, 74, 54, 10) + '<circle class="s-g" stroke-width="7" cx="303" cy="189" r="14"/><path class="s-p" stroke-width="7" d="M303 175 A14 14 0 0 1 316 194"/>';
      return s;
    },
    search: function () {
      var s = BG + card(20, 20, 320, 200, 14) + bar(20, 20, 320, 26, 'c-g') + '<circle class="c-w" cx="38" cy="33" r="4"/><circle class="c-w" cx="52" cy="33" r="4"/><circle class="c-w" cx="66" cy="33" r="4"/>';
      s += '<rect class="c-bg s-ln" x="42" y="60" width="226" height="30" rx="15"/><circle class="s-ink" stroke-width="2.5" cx="60" cy="75" r="6"/><line class="s-ink" stroke-width="2.5" x1="64" y1="79" x2="69" y2="84"/>' + bar(78, 72, 92, 7, 'c-ink');
      var ys = [104, 142, 180];
      ys.forEach(function (y, i) {
        if (i === 1) s += '<rect class="c-t" x="34" y="' + (y - 8) + '" width="292" height="34" rx="8"/>';
        s += bar(46, y, i === 1 ? 150 : 128, 8, i === 1 ? 'c-p' : 'c-ink') + bar(46, y + 13, 210, 6);
      });
      s += '<circle class="c-p" cx="304" cy="151" r="12"/><polyline class="s-w" stroke-width="3" points="298,154 304,147 310,154"/>';
      s += '<circle class="c-w s-p" stroke-width="8" cx="292" cy="208" r="20"/><line class="s-p" stroke-width="9" stroke-linecap="round" x1="306" y1="222" x2="322" y2="236"/>';
      return s;
    },
    ai: function () {
      var s = BG;
      [30, 92, 154].forEach(function (y, i) { s += card(22, y, 92, 54, 10) + bar(34, y + 12, 40, 7, i === 0 ? 'c-p' : 'c-ink') + bar(34, y + 26, 66, 5) + bar(34, y + 36, 54, 5); });
      s += card(150, 34, 190, 172, 16) + '<circle class="c-p" cx="172" cy="58" r="10"/>' + bar(190, 54, 70, 8, 'c-ink');
      s += bar(166, 82, 156, 6) + bar(166, 96, 144, 6) + bar(166, 110, 152, 6);
      s += '<rect class="c-t" x="164" y="126" width="162" height="40" rx="8"/>' + bar(174, 138, 120, 6, 'c-p') + bar(174, 150, 90, 6, 'c-p');
      s += bar(166, 180, 120, 6);
      s += '<path class="s-p dash" stroke-width="2" d="M114 57 C134 57 140 140 164 140"/><path class="s-ln dash" stroke-width="2" d="M114 119 C132 119 140 100 166 100"/>';
      s += '<circle class="c-p" cx="326" cy="126" r="9"/><text class="t-w" x="326" y="130" text-anchor="middle">1</text>';
      return s;
    },
    commerce: function () {
      var s = BG;
      [22, 133, 244].forEach(function (x, i) {
        var hi = i === 1;
        s += '<rect class="c-w ' + (hi ? 's-p' : 's-ln') + '" stroke-width="' + (hi ? 3 : 1) + '" x="' + x + '" y="' + (hi ? 26 : 40) + '" width="94" height="' + (hi ? 168 : 154) + '" rx="12"/>';
        var y = hi ? 36 : 50;
        s += '<rect class="c-t" x="' + (x + 10) + '" y="' + y + '" width="74" height="66" rx="8"/>';
        s += '<circle class="c-p" cx="' + (x + 30) + '" cy="' + (y + 20) + '" r="7"/><path class="' + (hi ? 'c-p' : 'c-g') + '" d="M' + (x + 14) + ' ' + (y + 62) + ' L' + (x + 40) + ' ' + (y + 34) + ' L' + (x + 56) + ' ' + (y + 50) + ' L' + (x + 66) + ' ' + (y + 42) + ' L' + (x + 80) + ' ' + (y + 62) + ' Z"/>';
        s += bar(x + 10, y + 78, 60, 7, 'c-ink') + bar(x + 10, y + 92, 44, 6) + bar(x + 10, y + 108, 36, 9, hi ? 'c-p' : 'c-ink');
        for (var k = 0; k < 5; k++) s += '<circle class="' + (k < (hi ? 5 : 3) ? 'c-amb' : 'c-g') + '" cx="' + (x + 14 + k * 11) + '" cy="' + (y + 130) + '" r="4"/>';
      });
      s += '<rect class="c-p" x="146" y="14" width="68" height="22" rx="11"/><polyline class="s-w" stroke-width="2.5" points="162,29 172,20 180,26 196,18"/>';
      s += '<path class="s-ink" stroke-width="3" d="M24 208 h14 l10 22 h44 l10 -16 h-60"/><circle class="c-ink" cx="56" cy="234" r="0"/>';
      return s;
    },
    lead: function () {
      var s = BG + card(22, 26, 144, 190, 14) + bar(38, 44, 70, 9, 'c-ink');
      [66, 102, 138].forEach(function (y) { s += bar(38, y, 40, 6) + '<rect class="c-bg s-ln" x="38" y="' + (y + 10) + '" width="112" height="20" rx="6"/>'; });
      s += '<rect class="c-p" x="38" y="182" width="112" height="22" rx="11"/>';
      s += '<path class="s-p dash" stroke-width="2.5" d="M166 116 C190 116 196 92 218 92"/><polyline class="s-p" stroke-width="2.5" points="210,86 218,92 210,98"/>';
      s += '<rect class="c-ink" x="222" y="18" width="104" height="206" rx="20"/><rect class="c-w" x="230" y="34" width="88" height="176" rx="12"/>';
      [50, 90, 130, 170].forEach(function (y, i) {
        s += '<circle class="' + (i < 3 ? 'c-ok' : 'c-g') + '" cx="246" cy="' + (y + 10) + '" r="8"/>' + (i < 3 ? '<polyline class="s-w" stroke-width="2.2" points="242,' + (y + 10) + ' 245,' + (y + 13) + ' 250,' + (y + 6) + '"/>' : '') + bar(260, y + 4, 44, 6, 'c-ink') + bar(260, y + 14, 30, 5);
      });
      s += '<path class="s-p" stroke-width="3" d="M334 70 a18 18 0 0 1 0 30"/><path class="s-p" stroke-width="3" d="M342 62 a28 28 0 0 1 0 46"/>';
      return s;
    },
    app: function () {
      var s = BG + '<rect class="c-ink" x="128" y="12" width="108" height="216" rx="22"/><rect class="c-w" x="136" y="28" width="92" height="186" rx="13"/>';
      s += bar(146, 40, 40, 8, 'c-ink') + '<rect class="c-p" x="146" y="56" width="72" height="36" rx="8"/>' + bar(154, 66, 34, 6, 'c-w') + bar(154, 78, 22, 6, 'c-w');
      [102, 138, 174].forEach(function (y, i) { s += '<rect class="c-bg" x="146" y="' + y + '" width="72" height="28" rx="7"/><circle class="c-amb" cx="160" cy="' + (y + 14) + '" r="7"/>' + bar(172, y + 9, 34, 5, 'c-ink') + bar(172, y + 17, 22, 4); });
      [0, 1, 2, 3].forEach(function (k) { s += '<ellipse class="c-amb s-amb" cx="70" cy="' + (186 - k * 13) + '" rx="30" ry="9"/>'; });
      s += '<circle class="s-g" stroke-width="9" cx="296" cy="90" r="34"/><path class="s-p" stroke-width="9" stroke-linecap="round" d="M296 56 A34 34 0 1 1 263 98"/>';
      s += bar(270, 150, 52, 8, 'c-ink') + bar(276, 164, 40, 6);
      return s;
    },
    place: function () {
      var s = BG + '<path class="c-t" d="M0 150 C80 120 120 190 200 160 S330 120 360 140 V200 C300 180 250 230 160 210 S40 190 0 210 Z" opacity=".7"/>';
      s += '<path class="s-road" stroke-width="14" d="M40 0 V240 M0 70 H360 M210 0 L260 240 M0 180 H120"/>';
      s += '<path class="s-p dash" stroke-width="4" d="M60 196 C100 160 120 110 170 100 S240 80 262 60"/>';
      [[262, 58, 1], [126, 112, 0], [60, 196, 0]].forEach(function (p) {
        var x = p[0], y = p[1];
        s += '<path class="' + (p[2] ? 'c-p' : 'c-ink') + '" d="M' + x + ' ' + y + ' c-14 -18 -16 -24 -16 -32 a16 16 0 0 1 32 0 c0 8 -2 14 -16 32 z"/><circle class="c-w" cx="' + x + '" cy="' + (y - 32) + '" r="6"/>';
      });
      s += card(232, 120, 112, 98, 12) + '<rect class="c-t" x="242" y="130" width="92" height="34" rx="6"/>' + bar(242, 172, 60, 8, 'c-ink');
      for (var k = 0; k < 5; k++) s += '<circle class="' + (k < 4 ? 'c-amb' : 'c-g') + '" cx="' + (248 + k * 12) + '" cy="194" r="4"/>';
      s += bar(242, 204, 76, 5);
      return s;
    },
    doc: function () {
      var s = BG + '<rect class="c-g" x="70" y="26" width="190" height="200" rx="12" transform="rotate(-4 165 126)"/>' + card(80, 18, 190, 204, 12) + bar(100, 38, 96, 10, 'c-ink') + bar(100, 56, 64, 6);
      [82, 116, 150, 184].forEach(function (y, i) { s += '<rect class="c-w s-ln" stroke-width="2" x="100" y="' + y + '" width="18" height="18" rx="4"/>' + (i < 3 ? '<polyline class="s-ok" stroke-width="3" points="103,' + (y + 9) + ' 108,' + (y + 14) + ' 116,' + (y + 4) + '"/>' : '') + bar(128, y + 3, 110 - i * 12, 6, 'c-ink') + bar(128, y + 12, 70, 5); });
      s += '<g transform="rotate(38 300 120)"><rect class="c-p" x="290" y="60" width="18" height="110" rx="4"/><path class="c-ink" d="M290 170 h18 l-9 18 z"/></g>';
      return s;
    },
    code: function () {
      var s = BG + card(20, 20, 220, 170, 14) + bar(20, 20, 220, 24, 'c-ink');
      [[40, 62, 90, 'c-p'], [56, 80, 120, 'c-ink'], [56, 98, 70, 'c-g'], [72, 116, 100, 'c-ink'], [56, 134, 84, 'c-g'], [40, 152, 60, 'c-p']].forEach(function (r) { s += bar(r[0], r[1], r[2], 7, r[3]); });
      s += card(176, 104, 164, 116, 14) + '<rect class="c-t" x="188" y="116" width="140" height="40" rx="6"/>' + bar(188, 166, 90, 7, 'c-ink') + bar(188, 180, 120, 6) + '<rect class="c-p" x="188" y="196" width="60" height="14" rx="7"/>';
      return s;
    }
  };
  SCENES.rank = function () {
    var s = BG + card(70, 26, 220, 188, 14) + bar(90, 44, 90, 8, 'c-ink') + bar(90, 58, 60, 6);
    [[84, 'c-g', 120, 1], [118, 'c-p', 150, 2], [152, 'c-g', 100, 3]].forEach(function (r) {
      s += '<rect class="' + (r[3] === 2 ? 'c-t' : 'c-bg') + '" x="86" y="' + (r[0] - 4) + '" width="188" height="28" rx="8"/>';
      s += '<circle class="' + (r[3] === 2 ? 'c-p' : 'c-g') + '" cx="102" cy="' + (r[0] + 10) + '" r="9"/><text class="t-w" x="102" y="' + (r[0] + 13) + '" text-anchor="middle">' + r[3] + '</text>';
      s += bar(118, r[0] + 6, r[2], 8, r[1] === 'c-p' ? 'c-p' : 'c-ink');
    });
    s += '<polyline class="s-p" stroke-width="4" points="262,136 262,112"/><polyline class="s-p" stroke-width="4" points="253,121 262,110 271,121"/>';
    return s;
  };

  function svg(w, h, inner, cls) {
    return '<svg class="' + cls + '" viewBox="0 0 ' + w + ' ' + h + '" xmlns="' + NS + '" aria-hidden="true" focusable="false">' + inner + '</svg>';
  }

  function esc(t) { return t.replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
  function el(tag, cls, html) { var e = document.createElement(tag); if (cls) e.className = cls; if (html != null) e.innerHTML = html; return e; }


  /* 1) 「선 + 글」 칸 → 테두리 카드 */
  var CARD_SEL = '.landing__point, .subcard, .landing__panel, .jc-door, .jc-why__item, .jc-product, .jc-goal, .jc-three > div, .jc-read > div, .jc-promise > div, .jc-plans > div, .jc-work, .work-preview, .jc-order-products li';
  var OWN_ICO = '.jc-door__ico, .jc-why__ico, .jc-product__ico, .jc-goal__ico';
  var GRID_SEL = '.landing__points, .subcards, .landing__split, .jc-doors, .jc-products, .jc-three, .jc-read, .jc-promise, .jc-plans';
  var LINKSCENE = [[/seo\/(aeo|geo)/, 'ai'], [/rankfree/, 'rank'], [/place/, 'place'], [/self-marketing|boostingshop|shopitrend|coupang|shopping|kakao/, 'commerce'], [/seo|backlink/, 'search'], [/cpa|call2sale|leadbay/, 'lead'], [/reward/, 'app'], [/wordpress/, 'code'], [/performance/, 'report'], [/marketing-support/, 'doc']];
  function sceneOf(c) {
    var a = c.matches('a[href]') ? c : c.querySelector('a[href]'); if (!a) return null;
    var h = a.getAttribute('href') || '', k = null;
    LINKSCENE.some(function (r) { if (r[0].test(h)) { k = r[1]; return true; } });
    return k;
  }
  var ALT = { commerce: 'report', lead: 'doc', app: 'commerce', place: 'search', report: 'doc', search: 'ai', code: 'doc' };
  function shot(k) { var d = el('span', 'jsx-shot', svg(360, 240, SCENES[k](), 'jsx-scene jsx-scene--' + k)); d.setAttribute('aria-hidden', 'true'); return d; }
  function cards(root) {
    var groups = [];
    root.querySelectorAll(CARD_SEL).forEach(function (c) {
      if (c.closest('.jsx-skip, .jc-wp-legacy, footer, header, nav.jc-gnb')) return;
      var p = c.parentElement, g = null;
      for (var i = 0; i < groups.length; i++) if (groups[i].p === p) g = groups[i];
      if (!g) { g = { p: p, items: [] }; groups.push(g); }
      g.items.push(c);
    });
    groups.forEach(function (g) {
      if (g.p.matches(GRID_SEL)) { g.p.classList.add('jsx-cards', 'jsx-cards--' + Math.min(g.items.length, 9)); }
      /* 묶음 안에 그림 카드·아이콘 카드가 있으면 → 링크 카드마다 같은 크기 화면 조각(그 서비스 화면 모양) */
      var pics = g.items.some(function (c) { return c.querySelector('.jc-nc-pick__art, ' + OWN_ICO); }) &&
        g.items.every(function (c) { return c.querySelector('.jc-nc-pick__art') || sceneOf(c); });
      var used = {};
      g.items.forEach(function (c) {
        if (c.classList.contains('jsx-card')) return;
        c.classList.add('jsx-card', 'jsx-card--left');
        [].forEach.call(c.querySelectorAll(OWN_ICO), function (o) { o.classList.add('jsx-hide'); });
        var art = c.querySelector('.jc-nc-pick__art');
        if (art) art.classList.add('jsx-shot');
        else if (pics) { var k = sceneOf(c); if (used[k]) k = [ALT[k]].concat(Object.keys(SCENES)).filter(function (x) { return x && !used[x]; })[0]; used[k] = 1; c.insertBefore(shot(k), c.firstChild); }
        if (c.matches('.jc-promise > div')) { var ul = c.querySelector('ul'); if (ul) ul.classList.add('jsx-checks', c.previousElementSibling ? 'jsx-checks--no' : 'jsx-checks--yes'); }
      });
      if (pics) g.p.classList.add('jsx-cards--pics');
    });
  }

  /* 2) 단계 → 번호 도식 */
  function steps(root) {
    root.querySelectorAll('.steps, .jc-order-steps, .jc-bigsteps').forEach(function (box) {
      var n = box.children.length; if (n < 2) return;
      box.classList.add('jsx-steps', n <= 6 ? 'jsx-steps--row' : 'jsx-steps--grid');
      box.style.setProperty('--n', Math.min(n, 6));
      [].forEach.call(box.children, function (it, i) { if (!it.querySelector('.jsx-no') && !it.querySelector('.jc-num')) it.insertAdjacentHTML('afterbegin', '<span class="jsx-no" aria-hidden="true">' + (i + 1) + '</span>'); });
    });
  }

  /* 3) 체크 목록 → 체크 카드 */
  function checks(root) {
    root.querySelectorAll('.landing__evidence').forEach(function (ul) { ul.classList.add('jsx-checks'); });
  }

  /* 4) 줄글 → 왼쪽 제목 · 오른쪽 문단 카드 */
  function prose(sec) {
    var inner = sec.querySelector(':scope > .landing__inner'); if (!inner) return;
    var pr = inner.querySelector(':scope > .prose'); if (!pr) return;
    if (inner.querySelector(':scope > :is(.landing__points, .steps, .subcards, .landing__split, .compare-table-wrap, .faq, .landing__evidence, .landing__chips)')) {
      pr.classList.add('jsx-prose-lead'); return;
    }
    var ps = [].slice.call(pr.children).filter(function (p) { return p.tagName === 'P' && p.textContent.trim().length > 0; });
    if (!ps.length) return;
    var left = el('div', 'jsx-split__l'), right = el('div', 'jsx-split__r jsx-pcards');
    ps.forEach(function (p) { var c = el('div', 'jsx-pcard'); c.appendChild(p); right.appendChild(c); });
    var kids = [].slice.call(inner.children);
    kids.forEach(function (k) { if (k !== pr) left.appendChild(k); });
    pr.remove();
    inner.appendChild(left); inner.appendChild(right);
    inner.classList.add('jsx-split');
  }

  /* 5) 질문 목록 · 표 */
  function faqs(root) {
    root.querySelectorAll('.faq, .jc-faq').forEach(function (f) { f.classList.add('jsx-faq'); });
    root.querySelectorAll('.compare-table-wrap').forEach(function (t) { t.classList.add('jsx-table'); });
  }

  /* 6) 원문 보존 칸(옛 워드프레스 본문) → 소제목마다 카드, 목록은 체크 카드 */
  function words(t) { return t.replace(/[^\w가-힣\s]/g, ' ').split(/\s+/).filter(Boolean); }
  function nearDup(a, b) { /* a 의 낱말 대부분이 b 에 있으면 같은 말 */
    var wa = words(a), wb = words(b); if (!wa.length || wa.length > wb.length) return false;
    var hit = wa.filter(function (w) { return wb.indexOf(w) > -1; }).length; return hit / wa.length >= 0.7;
  }
  function legacy(sec) {
    var body = sec.querySelector('.jc-wp-legacy__body'); if (!body || body.classList.contains('jsx-legacy')) return;
    body.classList.add('jsx-legacy');
    var kids = [].slice.call(body.children), grid = null, card = null, lead = null, dots = null;
    function isH(e, lv) { return e && /^H[2-4]$/.test(e.tagName) && +e.tagName[1] <= lv; }
    kids.forEach(function (k, i) {
      var t = k.tagName, nx = kids[i + 1];
      if (t === 'H2') { grid = card = lead = dots = null; return; }
      if (t === 'H3' || (t === 'H4' && (!card || card.firstElementChild.tagName === 'H4'))) {
        var lv = +t[1];
        if (!nx || isH(nx, lv)) {
          if (!lead) { lead = el('div', 'jsx-llead'); body.insertBefore(lead, k); }
          var q = el('p'); q.textContent = k.textContent; lead.appendChild(q); k.remove(); return;
        }
        if (!grid) { grid = el('div', 'jsx-lcards'); body.insertBefore(grid, k); }
        card = el('div', 'jsx-lcard'); grid.appendChild(card); card.appendChild(k); dots = null; return;
      }
      if (!card) { if (t === 'UL') k.classList.add('jsx-checks'); return; }
      if (t === 'H4' && (!nx || isH(nx, 4))) {
        if (!dots) { dots = el('ul', 'jsx-dots'); card.appendChild(dots); }
        var li = el('li'); li.textContent = k.textContent; dots.appendChild(li); k.remove(); return;
      }
      dots = null;
      if (t === 'UL') k.classList.add('jsx-dots');
      var prev = card.lastElementChild;
      if (t === 'P' && prev && prev.tagName === 'P' && (nearDup(k.textContent, prev.textContent) || nearDup(prev.textContent, k.textContent))) { k.remove(); return; }
      if (t === 'P' && k.textContent.trim().length < 50 && /\?$/.test(k.textContent.trim())) k.classList.add('jsx-lq');
      card.appendChild(k);
    });
    body.querySelectorAll('.jsx-llead').forEach(function (L) {
      var ps = [].slice.call(L.children);
      ps.forEach(function (p) { if (ps.some(function (o) { return o !== p && o.isConnected && o.textContent.length > p.textContent.length && nearDup(p.textContent, o.textContent); })) p.remove(); });
    });
    body.querySelectorAll('.jsx-lcards').forEach(function (g) { var n = g.children.length; g.classList.add('jsx-lcards--' + (n === 4 ? 4 : n >= 3 ? 3 : n)); });
  }

  /* 7) 히어로: 쪽 주제 화면 모양(검색 결과·신청서·상품 등) 또는 그 쪽 숫자 카드 */
  var HERO = [[/seo\/(aeo|geo)/, 'ai'], [/seo|backlink/, 'search'], [/cpa|call2sale|leadbay/, 'lead'], [/reward/, 'app'], [/rankfree|place/, 'place'], [/coupang|shopping|boostingshop|shopitrend|kakao/, 'commerce'], [/wordpress/, 'code'], [/performance/, 'report'], [/marketing-support/, 'doc']];
  function stats() {
    var out = [];
    document.querySelectorAll('main .home__stats .stat, main .stat.glass-card').forEach(function (s) {
      var n = s.querySelector('strong'), l = s.querySelector('span');
      if (n && l && out.length < 4) out.push([n.textContent.trim(), l.textContent.trim()]);
    });
    return out;
  }
  function hero(sec) {
    if ([].some.call(sec.querySelectorAll('figure, .landing__hero-figure, .jc-nc-hero, svg.scene-il__svg, img'), function (f) { return f.offsetWidth > 60 && f.offsetHeight > 60; })) return;
    [].forEach.call(sec.querySelectorAll('.landing__hero-figure'), function (f) { f.remove(); });
    var hi = sec.querySelector('.landing__hero-inner'); if (!hi) return;
    var fig;
    if (/about-us|company|^\/work/.test(PATH)) {
      var st = stats(); if (st.length < 2) return;
      fig = el('div', 'jsx-nums');
      st.forEach(function (s, i) { fig.appendChild(el('div', 'jsx-num' + (i === 0 ? ' is-key' : ''), '<b>' + esc(s[0]) + '</b><span>' + esc(s[1]) + '</span>')); });
    } else {
      var k = null; HERO.some(function (h) { if (h[0].test(PATH)) { k = h[1]; return true; } });
      if (!k || !SCENES[k]) return;
      fig = el('div', '', svg(360, 240, SCENES[k](), 'jsx-scene jsx-scene--' + k));
    }
    var txt = el('div', 'jsx-txt'); while (hi.firstChild) txt.appendChild(hi.firstChild);
    hi.appendChild(txt);
    var f = el('div', 'jsx-fig'); f.setAttribute('aria-hidden', 'true'); f.appendChild(fig); hi.appendChild(f);
    hi.classList.add('jsx-2col'); sec.classList.add('jsx-hero2');
  }

  /* 8) 쪽 안 메뉴 → 큰 탭 줄(지금 보는 칸 표시) */
  function tabs() {
    var nav = document.querySelector('.landing__local-nav'); if (!nav) return;
    nav.classList.add('jsx-tabs');
    var links = [].slice.call(nav.querySelectorAll('a[href*="#"]'));
    nav.style.setProperty('--n', links.length);
    var targets = links.map(function (a) { var id = a.getAttribute('href').split('#')[1]; return id ? document.getElementById(id) : null; });
    function on() {
      var y = window.scrollY + 180, cur = -1;
      targets.forEach(function (t, i) { if (t && t.getBoundingClientRect().top + window.scrollY <= y) cur = i; });
      links.forEach(function (a, i) { if (i === cur) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current'); });
    }
    window.addEventListener('scroll', on, { passive: true }); on();
  }

  /* 9) 순위 확인 띠: 작은 순위 도식 */
  /* 10) 「…전체 구조도 함께 살펴보세요」 띠 → 링크 카드(왼쪽 아이콘 · 글 · 오른쪽 버튼) */
  function related(sec) {
    var inner = sec.querySelector(':scope > .landing__inner'), eb = inner && inner.querySelector(':scope > .landing__eyebrow');
    if (!eb || !/Related/i.test(eb.textContent) || inner.classList.contains('jsx-related')) return;
    inner.classList.add('jsx-related');
  }

  /* 11) 이름 알약 묶음 → 아이콘 붙은 작은 카드 */
  function chips(root) {
    root.querySelectorAll('.landing__chips').forEach(function (box) {
      if (box.classList.contains('jsx-chipcards') || box.children.length < 4) return;
      box.classList.add('jsx-chipcards');
    });
  }

  function rankband() {
    var c = document.querySelector('#check .jc-check'); if (!c || c.querySelector('.jsx-rankfig')) return;
    var f = c.firstElementChild; if (!f) return;
    var s = '<rect class="c-w s-ln" x="1" y="1" width="94" height="70" rx="10"/>';
    [[14, 'c-g', 34], [32, 'c-p', 52], [50, 'c-g', 40]].forEach(function (r, i) {
      s += '<circle class="' + (i === 1 ? 'c-p' : 'c-g') + '" cx="14" cy="' + (r[0] + 3) + '" r="6"/>' + '<text class="t-w" x="14" y="' + (r[0] + 7) + '" text-anchor="middle">' + (i + 1) + '</text>';
      s += '<rect class="' + r[1] + '" x="26" y="' + r[0] + '" width="' + r[2] + '" height="7" rx="3.5"/>';
    });
    s += '<polyline class="s-p" stroke-width="3" points="80,46 80,30"/><polyline class="s-p" stroke-width="3" points="74,36 80,29 86,36"/>';
    var fig = el('div', 'jsx-rankfig', svg(96, 72, s, 'jsx-mini')); fig.setAttribute('aria-hidden', 'true');
    f.insertBefore(fig, f.firstChild); f.classList.add('jsx-rankhead');
  }

  function run() {
    var main = document.querySelector('main'); if (!main || document.body.classList.contains('jsx-done')) return;
    document.body.classList.add('jsx-done');
    var secs = [].slice.call(main.querySelectorAll('section')).filter(function (s) { return !s.parentElement.closest('section'); });
    secs.forEach(function (sec) {
      if (sec.classList.contains('jf')) return;
      if (sec.classList.contains('landing__hero')) { hero(sec); return; }
      if (sec.classList.contains('jc-wp-legacy')) { legacy(sec); return; }
      related(sec); prose(sec);
    });
    cards(main); steps(main); checks(main); faqs(main); chips(main); tabs(); rankband();
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run); else run();
})();
