document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".fade-up");
    elements.forEach((el, i) => {
        el.style.animationDelay = `${i * 0.15}s`; // 150ms stagger
    });
});

// Staggered fade-up + scroll-trigger for sections with .stagger-section
(function () {
    const getBaseMs = () => {
        const v = getComputedStyle(document.documentElement).getPropertyValue('--stagger-base') || '90ms';
        const n = parseInt(v.replace('ms', '').trim(), 10);
        return Number.isFinite(n) ? n : 90;
    };

    const baseMs = getBaseMs();

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const section = entry.target;

            // Find the inner grid (the div with inline width: 1080px) or fallback to first child div
            let grid = Array.from(section.children).find(c => c && c.style && c.style.width && c.style.width.indexOf('1080') !== -1);
            if (!grid) grid = section.querySelector('div');

            const items = grid ? Array.from(grid.children).filter(n => n.nodeType === 1) : [];

            items.forEach((it, i) => {
                // ensure initial hidden state (CSS will handle it via .stagger-item)
                if (!it.classList.contains('stagger-item')) it.classList.add('stagger-item');
                // set stagger delay from CSS variable
                it.style.transitionDelay = `${i * baseMs}ms`;
                // trigger visible state on next frame for smooth animation
                requestAnimationFrame(() => requestAnimationFrame(() => it.classList.add('is-visible')));
            });

            // also reveal the section itself if it has stagger-self
            if (section.classList.contains('stagger-self')) {
                section.classList.add('is-visible');
            }

            obs.unobserve(section);
        });
    }, { threshold: 0.12 });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.stagger-section').forEach(s => {
            // pre-mark children as stagger-item so CSS initial state applies
            let grid = Array.from(s.children).find(c => c && c.style && c.style.width && c.style.width.indexOf('1080') !== -1);
            if (!grid) grid = s.querySelector('div');
            if (grid) Array.from(grid.children).forEach(it => it.classList.add('stagger-item'));
            observer.observe(s);
        });
    });
})();

function navbarShowMenu() {
    const navMenu = document.getElementsByClassName('mobile-nav')[0];
    if (navMenu) {
        navMenu.classList.toggle('active');
    }
    const navMenuBack = document.getElementsByClassName('mobile-nav-back')[0];
    if (navMenuBack) {
        navMenuBack.classList.toggle('active');
    }
}
