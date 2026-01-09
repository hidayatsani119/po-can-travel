<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAN Travel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

<!-- Hero Section -->
<section class="relative h-screen bg-cover bg-center bg-white">



    <!-- Navbar -->
    <nav class="relative z-10 w-full mx-auto px-6 py-4 flex justify-between items-center text-gray-700  border-b ">
        <h1 class="text-xl font-bold">CAN Travel</h1>

        <div class="space-x-4">
            <a href="{{ route('login') }}"
               class="hover:text-gray-500">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="border border-gray-500 px-4 py-2 rounded-lg hover:bg-black hover:text-white">
                Register
            </a>
        </div>
    </nav>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center h-full text-center text-gray-700 px-6">
        <div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Bus Reservation Made Easy
            </h2>

            <p class="mb-8 text-lg text-gray-700">
                Pesan tiket bus dengan cepat, aman, dan nyaman
            </p>

            <a href="{{ route('login') }}"
               class="bg-blue-600 px-8 py-4 rounded-lg text-white font-semibold hover:bg-blue-700 transition">
                Get Started
            </a>
        </div>
    </div>

</section>

</body>
</html>
