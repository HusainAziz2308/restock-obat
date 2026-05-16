<nav class="bg-transparent absolute w-full top-0 z-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <span class="text-2xl font-bold text-white">Restock Obat</span>
        </div>

        <div class="hidden md:flex gap-6 items-center">
            <a href="/home" class="font-medium transition-colors duration-200 {{ Route::is('home.index') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-white/70 hover:text-white' }}">Home</a>
            <a href="/katalog" class="font-medium transition-colors duration-200 {{ Route::is('katalog.*') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-white/70 hover:text-white' }}">Katalog</a>
            <a href="/about" class="font-medium transition-colors duration-200 {{ Route::is('about.index') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-white/70 hover:text-white' }}">Tentang</a>
            <a href="/promo" class="font-medium transition-colors duration-200 {{ Route::is('promo.index') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-white/70 hover:text-white' }}">Promo</a>
            <a href="/contact" class="font-medium transition-colors duration-200 {{ Route::is('contact.index') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-white/70 hover:text-white' }}">Kontak</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Auth::check())
                <div x-data="{open: false}" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-300">User</p>
                        </div>
                        <img class="h-9 w-9 rounded-full object-cover border-2 border-gray-200 group-hover:border-blue-500 transition-all" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=EBF4FF&color=7F9CF5&bold=true" alt="{{ Auth::user()->name }}">
                        <svg class="w-4 h-4 text-gray-300 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl py-2 border border-gray-100 z-50 text-left">
                        <div class="px-4 py-2 border-b border-gray-50 sm:hidden">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        </div>
                        <a href="{{ url('/admin') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                            Dashboard Saya
                        </a>
                        <hr class="border-gray-100 my-1">
                        <form method="POST" action="{{ url('/admin/logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/admin/login" class="text-sm font-semibold text-white/90 hover:text-white transition-colors">Login</a>
                <a href="/admin/register" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors duration-200">Register</a>
            @endif
        </div>
    </div>
</nav>