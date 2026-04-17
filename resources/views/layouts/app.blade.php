<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotekKu</title>

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 flex flex-col min-h-screen">

    {{-- 🔝 NAVBAR --}}
    @include('partials.navbar')

    {{-- 📦 CONTENT --}}
    <main class="flex-1 p-6">

        {{-- 🔔 ALERT --}}
        @include('partials.alert')

        {{-- ISI HALAMAN --}}
        @yield('content')

    </main>

    {{-- 🔻 FOOTER --}}
    @include('partials.footer')

</body>
</html>
