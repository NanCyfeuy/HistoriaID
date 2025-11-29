@extends('layouts.app')

@section('title', 'Masuk ke Akun')

@section('content')
<div class="flex items-center justify-center min-h-screen pt-4 pb-12 sm:pt-0" style="background-color: #f7f7f7;">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-lg p-8 sm:p-10">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">
                Masuk ke HistoriaID
            </h2>

            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="kata_sandi" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <!-- Nama field HARUS 'kata_sandi' agar sesuai dengan AuthController -->
                    <input id="kata_sandi" name="kata_sandi" type="password" autocomplete="current-password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <!-- Route untuk Register (jika Anda membuatnya manual) -->
                        <a href="{{ url('/register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Belum punya akun? Daftar (TBD)
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection