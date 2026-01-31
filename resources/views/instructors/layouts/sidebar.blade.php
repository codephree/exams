<section class="lg:col-span-1">
				<div class="bg-white p-4 rounded-lg shadow-sm mb-6">
					<h3 class="text-sm font-semibold text-gray-600 mb-3">Quick Stats</h3>
					<div class="grid grid-cols-1 gap-3">
						<div class="flex items-center justify-between bg-blue-50 p-3 rounded">
							<div>
								<p class="text-xs text-gray-500">Active Exams</p>
								<p class="text-lg font-bold text-blue-600">12</p>
							</div>
							<div class="text-sm text-gray-500">+2 this week</div>
						</div>
						<div class="flex items-center justify-between bg-green-50 p-3 rounded">
							<div>
								<p class="text-xs text-gray-500">Students</p>
								<p class="text-lg font-bold text-green-600">1,234</p>
							</div>
							<div class="text-sm text-gray-500">+34 this month</div>
						</div>
						<div class="flex items-center justify-between bg-yellow-50 p-3 rounded">
							<div>
								<p class="text-xs text-gray-500">Pending Reviews</p>
								<p class="text-lg font-bold text-yellow-600">8</p>
							</div>
							<div class="text-sm text-gray-500">2 overdue</div>
						</div>
					</div>
				</div>

				<div class="bg-white p-4 rounded-lg shadow-sm">
					<h3 class="text-sm font-semibold text-gray-600 mb-3">Shortcuts</h3>
					<ul class="space-y-2 text-sm">
						<li><a href="{{ route('instructor.exam.create') }}" class="text-gray-700 hover:text-blue-600">Create new exam</a></li>
						<li><a href="#" class="text-gray-700 hover:text-blue-600">Import students</a></li>
						<li><a href="#" class="text-gray-700 hover:text-blue-600">Export results</a></li>
					</ul>
				</div>
			</section>