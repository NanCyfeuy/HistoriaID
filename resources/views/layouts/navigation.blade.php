<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Navigasi Kiri -->
            <div class="flex items-center space-x-6">
                <!-- Logo Utama -->
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800 tracking-wider hover:text-indigo-600 transition duration-150">
                    HistoriaID
                </a>
                
                <!-- Link Publik -->
                <a href="{{ route('public.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    Situs Budaya
                </a>
                <!-- Link Tambahan Publik (Jika Anda punya) -->
                <a href="#" class="text-gray-400 px-3 py-2 rounded-md text-sm font-medium cursor-not-allowed">
                    Tentang Kami (TBD)
                </a>
            </div>

            <!-- Navigasi Kanan (Auth/Guest) -->
            <div class="flex items-center space-x-4">
                
                {{-- BLOK UNTUK PENGGUNA YANG SUDAH LOGIN --}}
                @auth
                    
                    {{-- Tombol Dashboard Admin (Hanya terlihat jika peran = admin) --}}
                    @if(Auth::user()->peran === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out shadow-md">
                            Dashboard Admin
                        </a>
                    @endif
                    
                    <!-- Dropdown Nama Pengguna -->
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            {{ Auth::user()->nama }} {{-- AMAN: Karena di dalam @auth --}}
                            <svg class="ml-1 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                            <div class="py-1 bg-white rounded-md">
                                <!-- Logout Form -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- BLOK UNTUK PENGGUNA BELUM LOGIN --}}
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Masuk</a>
                    <a href="{{ url('/register') }}" class="bg-indigo-500 text-white hover:bg-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out">Daftar</a>
                @endguest
            </div>
        </div>
    </div>
</nav>