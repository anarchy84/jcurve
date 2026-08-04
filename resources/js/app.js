import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

window.Alpine = Alpine;
Alpine.start();

// 접근성: 모션 최소화 선호 시 GSAP 전체 스킵.
// → 히어로는 정적, 통계는 HTML에 박힌 최종값(373억+ 등)이 그대로 노출된다.
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!prefersReduced) {
    gsap.registerPlugin(ScrollTrigger);

    // S1 히어로 스크롤 줌: 스크롤 진행에 따라 비디오 프레임 scale 1.0 → 0.62 + radius 0 → 24
    const heroMedia = document.querySelector('[data-hero-zoom]');
    const hero = document.querySelector('.home__hero');
    if (heroMedia && hero) {
        gsap.to(heroMedia, {
            scale: 0.62,
            borderRadius: '24px',
            ease: 'none',
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: true,
            },
        });
    }

    // S3 통계 카운트업: 뷰포트 진입 시 0 → 목표값. 한 번만 실행.
    document.querySelectorAll('[data-count-to]').forEach((el) => {
        const target = parseFloat(el.dataset.countTo);
        const decimals = parseInt(el.dataset.countDecimals || '0', 10);
        const suffix = el.dataset.countSuffix || '';
        const useComma = el.dataset.countComma === '1';
        const counter = { val: 0 };

        const render = (v) => {
            let n = v.toFixed(decimals);
            if (useComma) n = Number(n).toLocaleString('en-US');
            el.textContent = n + suffix;
        };

        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            once: true,
            onEnter: () => {
                gsap.to(counter, {
                    val: target,
                    duration: 1.6,
                    ease: 'power2.out',
                    onUpdate: () => render(counter.val),
                    onComplete: () => render(target),
                });
            },
        });
    });
}
