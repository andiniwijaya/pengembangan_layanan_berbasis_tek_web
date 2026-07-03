{{-- Hero carousel Flowbite dengan overlay teks, CTA, auto-slide, dan swipe mobile --}}
<section class="relative overflow-hidden bg-gradient-to-br from-secondary via-background to-primary/20 dark:from-dark-card dark:via-dark-bg dark:to-primary/10">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <div id="hero-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="5000" role="region" aria-label="Banner promosi WijayCart" aria-roledescription="carousel">
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                @foreach($heroSlides as $index => $slide)
                <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                    <div class="relative aspect-[4/3] sm:aspect-[16/9] lg:aspect-[21/9] max-h-[560px] w-full">
                        <img
                            src="{{ $slide['image'] }}"
                            alt="{{ $slide['alt'] }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center">
                            <div class="animate-slide-up max-w-xl px-6 py-8 sm:px-10 lg:px-14">
                                <span class="mb-3 inline-flex items-center gap-2 rounded-full bg-primary/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-accent">
                                    <i data-lucide="sparkles" class="h-3.5 w-3.5" aria-hidden="true"></i>
                                    Lifestyle Collection 2026
                                </span>
                                <h1 class="mb-4 text-2xl font-bold leading-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">
                                    {{ $slide['title'] }}
                                </h1>
                                <p class="mb-6 text-sm leading-relaxed text-white/85 sm:text-base lg:text-lg">
                                    {{ $slide['subtitle'] }}
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ $slide['shop_url'] }}" class="btn-accent text-sm">
                                        Belanja Sekarang
                                        <i data-lucide="arrow-right" class="h-4 w-4" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ $slide['catalog_url'] }}" class="btn-secondary border-white/30 bg-white/10 text-white backdrop-blur-sm hover:bg-white/20">
                                        Lihat Katalog
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Indicators --}}
            <div class="absolute bottom-4 left-1/2 z-30 flex -translate-x-1/2 gap-2 sm:bottom-6">
                @foreach($heroSlides as $index => $slide)
                <button
                    type="button"
                    class="h-2.5 w-2.5 rounded-full bg-white/50 transition-all duration-300 hover:bg-white/80 {{ $index === 0 ? 'w-6 bg-white' : '' }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}"
                ></button>
                @endforeach
            </div>

            {{-- Navigation --}}
            <button
                type="button"
                class="group absolute left-2 top-1/2 z-30 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-sm transition-all hover:bg-white/40 focus:outline-none focus:ring-2 focus:ring-primary sm:left-4 sm:h-12 sm:w-12"
                data-carousel-prev
                aria-label="Slide sebelumnya"
            >
                <i data-lucide="chevron-left" class="h-5 w-5" aria-hidden="true"></i>
            </button>
            <button
                type="button"
                class="group absolute right-2 top-1/2 z-30 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-sm transition-all hover:bg-white/40 focus:outline-none focus:ring-2 focus:ring-primary sm:right-4 sm:h-12 sm:w-12"
                data-carousel-next
                aria-label="Slide berikutnya"
            >
                <i data-lucide="chevron-right" class="h-5 w-5" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</section>
