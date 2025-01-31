<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
            <div class="flex gap-[5px]">
                @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg transition">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg transition">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg transition">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-10">
        @yield('content')
    </main>

    @vite(['resources/js/main.js'])
</body>

</html>