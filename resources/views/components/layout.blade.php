<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FINTRASC')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        <x-sidebar />
        <main class="flex-1 p-6">
            <div class="flex justify-end mb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-[#702963] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#8a3379] transition-colors">
                        LOGOUT
                    </button>
                </form>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

