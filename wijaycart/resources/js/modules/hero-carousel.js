/**
 * Modul Hero Carousel WijayCart.
 * Flowbite Carousel dengan dukungan swipe touch pada mobile.
 */

export function initHeroCarousel() {
    const carouselEl = document.getElementById('hero-carousel');
    if (!carouselEl) return;

    let touchStartX = 0;
    let touchEndX = 0;

    const goNext = () => carouselEl.querySelector('[data-carousel-next]')?.click();
    const goPrev = () => carouselEl.querySelector('[data-carousel-prev]')?.click();

    carouselEl.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carouselEl.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        const threshold = 50;

        if (Math.abs(diff) < threshold) return;

        if (diff > 0) {
            goNext();
        } else {
            goPrev();
        }
    }, { passive: true });

    carouselEl.addEventListener('slideChanged', () => {
        window.initLucideIcons?.();
        updateIndicators(carouselEl);
    });

    carouselEl.querySelectorAll('[data-carousel-slide-to]').forEach((btn) => {
        btn.addEventListener('click', () => {
            setTimeout(() => updateIndicators(carouselEl), 50);
        });
    });

    carouselEl.querySelectorAll('[data-carousel-prev], [data-carousel-next]').forEach((btn) => {
        btn.addEventListener('click', () => {
            setTimeout(() => updateIndicators(carouselEl), 50);
        });
    });
}

function updateIndicators(carouselEl) {
    const items = carouselEl.querySelectorAll('[data-carousel-item]');
    const buttons = carouselEl.querySelectorAll('[data-carousel-slide-to]');
    let activeIndex = 0;

    items.forEach((item, index) => {
        if (!item.classList.contains('hidden')) {
            activeIndex = index;
        }
    });

    buttons.forEach((btn, index) => {
        const isActive = index === activeIndex;
        btn.setAttribute('aria-current', isActive ? 'true' : 'false');
        btn.classList.toggle('w-6', isActive);
        btn.classList.toggle('bg-white', isActive);
        btn.classList.toggle('bg-white/50', !isActive);
    });
}
