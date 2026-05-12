<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restock Obat - Kelompok 4</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">

    <nav class="bg-blue-600 p-4 shadow-lg">
        <div class="mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-xl tracking-wider">
                💊 Restock Obat
            </div>
            <div>
                <ul class="flex space-x-6 text-white font-medium">
                    <li><a href="/home" class="hover:border-b-2 transition">Home</a></li>
                    <li><a href="/obat" class="hover:border-b-2 transition">Katalog</a></li>
                    <li><a href="/profil" class="hover:border-b-2 transition">Profil</a></li>
                </ul>
            </div>
            <div>
                @if (Auth::check())
                    <a href="{{ url('/admin') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 hover:scale-110 transition inline-block">
                        Dashboard
                    </a>
                @else
                    <a href="{{ url('/admin') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 hover:scale-110 transition inline-block">
                        Login
                    </a>
                    <a href="{{ url('/admin/register') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 hover:scale-110 transition inline-block">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-15">
        @yield('content')
    </main>
    @extends('partials.footer')
</body>

</html>