<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Instructor Dashboard</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		/* small helper to limit content width */
		.container-max { max-width: 1200px; }
	</style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
	<!-- Top horizontal navigation -->
	<header class="bg-white shadow-sm">
		<div class="mx-auto container-max px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between items-center h-16">
				<div class="flex items-center space-x-4">
					<a href="#" class="text-xl font-semibold text-blue-600">Instructor Panel</a>
					<nav class="hidden md:flex items-center space-x-2">
						<a href="{{ route('instructor.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
						<a href="{{ route('instructor.view_exams') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Exams</a>
						<a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Students</a>
						<a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Results</a>
						<a href="{{ route('instructor.settings') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Settings</a>
					</nav>
				</div>

				<div class="flex items-center space-x-4">
					<div class="hidden sm:flex items-center text-sm text-gray-600">
						<span class="mr-3">Welcome, <strong>{{ Auth::guard('instructors')->user()->name }}</strong></span>
					</div>

					   <form action="{{ route('instructor.logout') }}" method="post" class="logout" id="logout">
                    @csrf
					 <a onclick="document.getElementById('logout').submit(); return false;" class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">Logout</a>
                </form>
					
					<!-- mobile menu button -->
					<button id="mobile-menu-button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100">
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
					</button>
				</div>
			</div>
		</div>
		<!-- Mobile nav -->
		<div id="mobile-menu" class="md:hidden hidden border-t border-gray-100">
			<div class="px-4 pt-2 pb-3 space-y-1">
				<a href="{{ route('instructor.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
				<a href="{{ route('instructor.view_exams') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Exams</a>
				<a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Students</a>
				<a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Results</a>
				<a href="{{ route('instructor.settings') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Settings</a>
			</div>
		</div>
	</header>
    <main class="mx-auto container-max px-4 sm:px-6 lg:px-8 py-8">
    @yield('content')
  	</main>

	<script>
		const btn = document.getElementById('mobile-menu-button');
		const menu = document.getElementById('mobile-menu');
		btn && btn.addEventListener('click', () => menu.classList.toggle('hidden'));
	</script>
	@yield('scripts')
</body>
</html>

