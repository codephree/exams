<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-600 text-white py-4 shadow-md">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Student Dashboard</h1>
                 @isset($duration)
                    
                    <span id="countdown" class="text-white text-sm"></span>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const duration = {{ $duration }};
                            let timeRemaining = duration * 60; // Convert minutes to seconds

                            const countdownElement = document.getElementById('countdown');

                            function updateCountdown() {
                                const minutes = Math.floor(timeRemaining / 60);
                                const seconds = timeRemaining % 60;
                                countdownElement.textContent = `Time Remaining: ${minutes}m ${seconds}s`;

                                if (timeRemaining > 0) {
                                    timeRemaining--;
                                } else {
                                    clearInterval(countdownInterval);
                                    countdownElement.textContent = "Time's up!";
                                    document.getElementById('examForm').submit();
                                }
                            }

                            const countdownInterval = setInterval(updateCountdown, 1000);
                            updateCountdown();
                        });
                    </script>
                @endisset
                <form action="{{ route('student.logout') }}" method="post" class="logout" id="logout">
                    @csrf
                     <a  onclick="document.getElementById('logout').submit(); return false;" 
                            class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Logout</a>
                </form>
            </div>
        </header>

        @yield('content')
        
          <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; 2025 Student Dashboard. All rights reserved.</p>
            </div>
        </footer>
    </div>
    @section('scripts')
    
</body>
</html>