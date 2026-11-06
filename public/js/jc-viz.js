/* 제이커브 페이지 그림 (2026-11-06 2판) — 짝 파일 public/css/jc-viz.css
   움직이는 곳은 data-jf-anim 이 붙은 두 곳(회사소개 연혁 선 · 지원사업 일정 막대)뿐.
   화면에 들어오면 is-in 을 한 번 붙인다. 움직임 줄이기 설정이면 바로 붙인다. */
(() => {
    document.body.classList.add('jv');
    const els = document.querySelectorAll('[data-jf-anim]');
    if (!els.length) return;
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) { els.forEach((el) => el.classList.add('is-in')); return; }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { threshold: 0.3 });
    els.forEach((el) => io.observe(el));
})();
