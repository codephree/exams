<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Instructions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex items-center justify-between">
            <h1 class="text-3xl font-bold">Welcome to the Exam Instructions</h1>
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">Logout</button>
            </form>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="underline">Login</a>
            @endguest
        </div>
    </header>
    @auth
    <div class="container mx-auto my-4 px-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            <p class="font-semibold">Hello, {{ auth()->user()->name }} — welcome back!</p>
        </div>
    </div>
    @endauth
    @guest
    <div class="container mx-auto my-4 px-4">
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            <p class="font-semibold">Welcome! <a href="{{ route('login') }}" class="underline">Log in</a> to access the exam.</p>
        </div>
    </div>
    @endguest
    <main class="container mx-auto my-8 px-4">
        <section class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Follow These Steps</h2>
            <ol class="list-decimal list-inside space-y-2">
                <li>Read all the instructions carefully before starting the exam.</li>
                <li>Ensure you have a stable internet connection.</li>
                <li>Keep your ID card and other necessary documents ready.</li>
                <li>Do not navigate away from the exam window during the test.</li>
                <li>Submit your answers before the timer runs out.</li>
            </ol>
        </section>

        <section class="mt-8">
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                <p class="font-bold">Important:</p>
                <p>Make sure to double-check your answers before submitting.</p>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Exam Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>