<div x-data="{ activeSlide: 0, slideCount: {{ count($sliders) }} }"
     x-init="setInterval(() => { activeSlide = (activeSlide === slideCount - 1) ? 0 : activeSlide + 1 }, 5000)"
     class="relative bg-slate-900 pt-32 pb-16 overflow-hidden">

    <div class="absolute inset-0 z-0">
        @foreach ($sliders as $index => $slide)
        <div x-show="activeSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-800"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 w-full h-full bg-cover bg-center"
             style="--bg-image: url('{{ $slide['image'] }}'); background-image: var(--bg-image);">
        </div>
        @endforeach
    </div>

    <div class="absolute inset-0 bg-slate-950/80 z-0 backdrop-blur-[2px]"></div>

    <div class="relative z-10 max-w-full mx-auto px-6 md:px-12 text-center md:text-left flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                @yield('page_title')
            </h1>
            <p class="mt-2 text-sm md:text-base text-slate-300 max-w-2xl">
                @yield('page_description')
            </p>
        </div>

        <nav class="flex justify-center md:justify-start items-center gap-2 text-xs font-semibold text-slate-300">
            <a href="/home" class="hover:text-white transition-colors">Home</a>
            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-blue-400">@yield('page_title')</span>
        </nav>
    </div>
</div>
