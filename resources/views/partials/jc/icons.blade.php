{{--
    제이커브 아이콘 세트 (SVG 스프라이트) — 직접 그린 선 아이콘, 2026-10-27
    - 24×24 격자, 선 1.6px, 둥근 끝·둥근 모서리, 색은 currentColor(글자색을 따른다)
    - 레이아웃에서 한 번만 include 하고, 화면에서는 <x-jc.icon name="seo" /> 로 쓴다.
    - 글자·로고는 넣지 않는다(서비스 로고는 실제 파일로만).
--}}
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden" aria-hidden="true" focusable="false">
    <defs>
        {{-- ── 마케팅 서비스 ── --}}
        <symbol id="ji-performance" viewBox="0 0 24 24"><path d="M3.5 20.5h17"/><path d="M6.5 17v-3.5"/><path d="M11 17V11"/><path d="M15.5 17V8.5"/><path d="M5 10.5 10 6l3.5 3L20 3.5"/><path d="M16 3.5h4v4"/></symbol>
        <symbol id="ji-cpa" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="7"/><circle cx="10.5" cy="10.5" r="3.2"/><path d="m14.5 14.5 6 6"/><path d="M20.5 16.5v4h-4"/></symbol>
        <symbol id="ji-reward" viewBox="0 0 24 24"><circle cx="12" cy="13" r="7.5"/><path d="M10.2 16.8V9.4h2.6a2.2 2.2 0 0 1 0 4.4h-2.6"/><path d="M12 2.5v1.6"/><path d="m5.3 4.8 1.1 1.2"/><path d="m18.7 4.8-1.1 1.2"/></symbol>
        <symbol id="ji-seo" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="7"/><path d="m15.6 15.6 5 5"/><path d="m7.2 12.6 2.2-2.4 1.8 1.6 2.6-3.2"/></symbol>
        <symbol id="ji-aeo" viewBox="0 0 24 24"><path d="M20.5 12a8.5 8.5 0 0 1-12.4 7.6L3.5 20.5l1-4.4A8.5 8.5 0 1 1 20.5 12Z"/><path d="M12 7.8 13 10.6l2.8 1-2.8 1-1 2.8-1-2.8-2.8-1 2.8-1Z"/></symbol>
        <symbol id="ji-geo" viewBox="0 0 24 24"><circle cx="11" cy="12" r="8.5"/><path d="M2.5 12h17"/><path d="M11 3.5c2.3 2.4 3.4 5.2 3.4 8.5S13.3 18.1 11 20.5c-2.3-2.4-3.4-5.2-3.4-8.5S8.7 5.9 11 3.5Z"/><path d="m19.5 2.5.6 1.6 1.6.6-1.6.6-.6 1.6-.6-1.6-1.6-.6 1.6-.6Z"/></symbol>
        <symbol id="ji-place" viewBox="0 0 24 24"><path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.4"/></symbol>
        <symbol id="ji-shopping" viewBox="0 0 24 24"><path d="M5 8h14l-1.1 11.2a1.5 1.5 0 0 1-1.5 1.3H7.6a1.5 1.5 0 0 1-1.5-1.3Z"/><path d="M8.8 10.5V7a3.2 3.2 0 0 1 6.4 0v3.5"/></symbol>
        <symbol id="ji-coupang" viewBox="0 0 24 24"><path d="m12 2.8 8 4.4v9.6l-8 4.4-8-4.4V7.2Z"/><path d="m4 7.2 8 4.4 8-4.4"/><path d="M12 11.6v9.6"/><path d="m8 5 8 4.4"/></symbol>
        <symbol id="ji-gift" viewBox="0 0 24 24"><rect x="3.5" y="8.5" width="17" height="4" rx="1"/><path d="M5 12.5v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7"/><path d="M12 8.5v12"/><path d="M12 8.5C10.8 5 8.2 4 7.2 5.2c-1 1.2.4 3.3 4.8 3.3Z"/><path d="M12 8.5c1.2-3.5 3.8-4.5 4.8-3.3 1 1.2-.4 3.3-4.8 3.3Z"/></symbol>
        <symbol id="ji-backlink" viewBox="0 0 24 24"><path d="M10 14a4.5 4.5 0 0 0 6.4 0l3-3a4.5 4.5 0 0 0-6.4-6.4l-1.2 1.2"/><path d="M14 10a4.5 4.5 0 0 0-6.4 0l-3 3a4.5 4.5 0 0 0 6.4 6.4l1.2-1.2"/></symbol>
        <symbol id="ji-wordpress" viewBox="0 0 24 24"><rect x="2.5" y="4" width="19" height="16" rx="2"/><path d="M2.5 8.5h19"/><circle cx="5.5" cy="6.25" r=".4" fill="currentColor"/><circle cx="7.5" cy="6.25" r=".4" fill="currentColor"/><path d="M6 12.5h6"/><path d="M6 15.5h4"/><rect x="14" y="11.5" width="4.5" height="5" rx=".8"/></symbol>
        <symbol id="ji-support" viewBox="0 0 24 24"><path d="M3.5 9.5 12 4l8.5 5.5"/><path d="M5.5 10v8"/><path d="M9.8 10v8"/><path d="M14.2 10v8"/><path d="M18.5 10v8"/><path d="M3 20.5h18"/></symbol>

        {{-- ── 셀프마케팅·운영 서비스 ── --}}
        <symbol id="ji-self" viewBox="0 0 24 24"><path d="M4 6.5h9"/><path d="M17 6.5h3"/><circle cx="15" cy="6.5" r="2"/><path d="M4 12h3"/><path d="M11 12h9"/><circle cx="9" cy="12" r="2"/><path d="M4 17.5h11"/><path d="M19 17.5h1"/><circle cx="17" cy="17.5" r="2"/></symbol>
        <symbol id="ji-rankfree" viewBox="0 0 24 24"><rect x="9" y="7" width="6" height="13.5" rx="1"/><rect x="3" y="11.5" width="6" height="9" rx="1"/><rect x="15" y="14" width="6" height="6.5" rx="1"/><path d="m12 2.5.9 1.8 2 .3-1.4 1.4.3 2-1.8-1-1.8 1 .3-2-1.4-1.4 2-.3Z"/></symbol>
        <symbol id="ji-boostingshop" viewBox="0 0 24 24"><path d="M14.5 3.5c3.2 0 6 2.8 6 6 0 4.2-4 7.4-6.5 8.8l-1.8-1.8-3.7-3.7-1.8-1.8C8.1 8.5 10.3 3.5 14.5 3.5Z"/><circle cx="15" cy="9" r="1.8"/><path d="M8.7 12.8 5 13.6l-1.5 3 3.4-.3"/><path d="m11.2 15.3-.8 3.7-3 1.5.3-3.4"/></symbol>
        <symbol id="ji-shopitrend" viewBox="0 0 24 24"><path d="M3 4.5h2l2.2 10.2a1.5 1.5 0 0 0 1.5 1.2h8.1a1.5 1.5 0 0 0 1.4-1l2.3-6.4H6.4"/><circle cx="9" cy="19.5" r="1.3"/><circle cx="17" cy="19.5" r="1.3"/><path d="m10 11.8 2.2-2 1.8 1.4 2.6-2.6"/></symbol>
        <symbol id="ji-leadbay" viewBox="0 0 24 24"><path d="M3.5 4.5h17l-6.5 7.8v6.2l-4 2v-8.2Z"/><path d="M8 4.5V3"/><path d="M12 4.5V3"/><path d="M16 4.5V3"/></symbol>
        <symbol id="ji-call2sale" viewBox="0 0 24 24"><path d="M4 13.5v-1.5a8 8 0 0 1 16 0v1.5"/><rect x="3" y="13" width="4" height="6" rx="1.5"/><rect x="17" y="13" width="4" height="6" rx="1.5"/><path d="M19 19c0 1.4-1.6 2.5-4.5 2.5H12.5"/></symbol>
        <symbol id="ji-apps" viewBox="0 0 24 24"><rect x="5.5" y="2.5" width="13" height="19" rx="2.5"/><path d="M10 18.5h4"/><rect x="8" y="6" width="3" height="3" rx=".8"/><rect x="13" y="6" width="3" height="3" rx=".8"/><rect x="8" y="11" width="3" height="3" rx=".8"/><rect x="13" y="11" width="3" height="3" rx=".8"/></symbol>

        {{-- ── 공통 ── --}}
        <symbol id="ji-arrow-right" viewBox="0 0 24 24"><path d="M4.5 12h15"/><path d="m13.5 6 6 6-6 6"/></symbol>
        <symbol id="ji-external" viewBox="0 0 24 24"><path d="M7 17 17 7"/><path d="M8.5 7H17v8.5"/></symbol>
        <symbol id="ji-check" viewBox="0 0 24 24"><path d="m4.5 12.5 5 5 10-11"/></symbol>
        <symbol id="ji-phone" viewBox="0 0 24 24"><path d="M5 3.5h3.3l1.7 4.3-2.2 1.4a11 11 0 0 0 5 5l1.4-2.2 4.3 1.7V17a2 2 0 0 1-2 2A15.5 15.5 0 0 1 3 5.5a2 2 0 0 1 2-2Z"/></symbol>
        <symbol id="ji-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6.5 8.5-6.5"/></symbol>
        <symbol id="ji-shield" viewBox="0 0 24 24"><path d="M12 3 4.5 6v5.5c0 4.6 3.2 8.2 7.5 9.5 4.3-1.3 7.5-4.9 7.5-9.5V6Z"/><path d="m8.8 12 2.2 2.2 4.4-4.6"/></symbol>
        <symbol id="ji-layers" viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5Z"/><path d="m3 12.5 9 5 9-5"/><path d="m3 17 9 5 9-5"/></symbol>
        <symbol id="ji-network" viewBox="0 0 24 24"><circle cx="12" cy="5" r="2.2"/><circle cx="5" cy="18" r="2.2"/><circle cx="19" cy="18" r="2.2"/><circle cx="12" cy="13" r="2.2"/><path d="M12 7.2v3.6"/><path d="m10.3 14.5-3.6 2.2"/><path d="m13.7 14.5 3.6 2.2"/></symbol>
        <symbol id="ji-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.7a3.5 3.5 0 0 1 0 6.6"/><path d="M18.5 14.2A6.5 6.5 0 0 1 21.5 20"/></symbol>
        <symbol id="ji-store" viewBox="0 0 24 24"><path d="M4 9.5V20h16V9.5"/><path d="M3 9.5 4.8 4h14.4L21 9.5c0 1.4-1.2 2.5-2.7 2.5s-2.6-1.1-2.6-2.5c0 1.4-1.2 2.5-2.7 2.5s-2.7-1.1-2.7-2.5c0 1.4-1.2 2.5-2.6 2.5S3 10.9 3 9.5Z"/><path d="M9.5 20v-5h5v5"/></symbol>
        <symbol id="ji-megaphone" viewBox="0 0 24 24"><path d="M3.5 10v4a1 1 0 0 0 1 1h2.5l8 4.5V4.5l-8 4.5H4.5a1 1 0 0 0-1 1Z"/><path d="M7.5 15 9 20.5"/><path d="M18.5 9a4 4 0 0 1 0 6"/></symbol>
        <symbol id="ji-spark" viewBox="0 0 24 24"><path d="M12 3.5 13.8 10l6.7 2-6.7 2L12 20.5 10.2 14 3.5 12l6.7-2Z"/></symbol>
        <symbol id="ji-play" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5Z"/></symbol>
    </defs>
</svg>
