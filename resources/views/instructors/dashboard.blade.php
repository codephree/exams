@extends('instructors.layouts.app')

@section('content')
	
		<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
			<!-- Left column: stats & menu -->
			@include('instructors.layouts.sidebar')

			<!-- Main content -->
			<section class="lg:col-span-3">
				<div class="bg-white p-6 rounded-lg shadow-sm mb-6">
					<div class="flex items-center justify-between mb-4">
						<h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
						<div class="flex items-center space-x-2">
							<button class="px-3 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">New Exam</button>
							<button class="px-3 py-2 border border-gray-200 rounded text-sm hover:bg-gray-50">Filters</button>
						</div>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
						<div class="p-4 bg-gray-50 rounded">
							<p class="text-sm text-gray-500">Upcoming Exam</p>
							<p class="mt-2 font-semibold text-gray-800">Midterm - Biology</p>
							<p class="text-xs text-gray-500 mt-1">Starts: Feb 1, 2026</p>
						</div>
						<div class="p-4 bg-gray-50 rounded">
							<p class="text-sm text-gray-500">Submissions</p>
							<p class="mt-2 font-semibold text-gray-800">320 / 400</p>
							<p class="text-xs text-gray-500 mt-1">Due: Jan 30, 2026</p>
						</div>
						<div class="p-4 bg-gray-50 rounded">
							<p class="text-sm text-gray-500">Average Score</p>
							<p class="mt-2 font-semibold text-gray-800">78%</p>
							<p class="text-xs text-gray-500 mt-1">Past 30 days</p>
						</div>
					</div>

					<div class="space-y-4">
						<div class="p-4 border border-gray-100 rounded">
							<h4 class="font-semibold text-gray-800">Recent Activity</h4>
							<ul class="mt-2 text-sm text-gray-600 space-y-2">
								<li>Jane Doe submitted <span class="font-medium text-gray-800">Biology Midterm</span>.</li>
								<li>Exam <span class="font-medium text-gray-800">Algebra Final</span> was published.</li>
								<li>New student <span class="font-medium text-gray-800">John Smith</span> added.</li>
							</ul>
						</div>

						<div class="p-4 border border-gray-100 rounded">
							<h4 class="font-semibold text-gray-800">Announcements</h4>
							<p class="mt-2 text-sm text-gray-600">No announcements. Use the Create button to post a new announcement to your students.</p>
						</div>
					</div>
				</div>

				<div class="bg-white p-6 rounded-lg shadow-sm">
					<h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Results</h3>
					<div class="overflow-x-auto">
						<table class="min-w-full divide-y divide-gray-200 text-sm">
							<thead>
								<tr class="bg-gray-50">
									<th class="px-4 py-2 text-left font-medium text-gray-600">Student</th>
									<th class="px-4 py-2 text-left font-medium text-gray-600">Exam</th>
									<th class="px-4 py-2 text-left font-medium text-gray-600">Score</th>
									<th class="px-4 py-2 text-left font-medium text-gray-600">Submitted</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-100">
								<tr>
									<td class="px-4 py-3">Jane Doe</td>
									<td class="px-4 py-3">Biology Midterm</td>
									<td class="px-4 py-3">85%</td>
									<td class="px-4 py-3">Jan 22, 2026</td>
								</tr>
								<tr>
									<td class="px-4 py-3">John Smith</td>
									<td class="px-4 py-3">Chemistry Quiz</td>
									<td class="px-4 py-3">72%</td>
									<td class="px-4 py-3">Jan 21, 2026</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

@endsection