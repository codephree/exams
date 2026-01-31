@extends('instructors.layouts.app')
@section('title', 'View Exams')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ Auth::guard('instructors')->user()->name }}'s Exams</h1>
    <div class="bg-white shadow-sm rounded-lg p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Scheduled</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Example exam row -->
                 @foreach ($exams as $exam)
                <tr data-id="{{ $exam->id }}" data-description="{{ $exam->description ?? '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 exam-title">{{ $exam->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 exam-date">{{ formatDate($exam->start_time) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 exam-created">{{ $exam->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 data-description hidden">{{ $exam->description ?? 'No description available' }}</td>
                    <td class="exam-duration hidden">{{ $exam->duration_minutes }}</td>
                    <td class="exam-marks hidden">{{ $exam->total_marks }}</td>
                    <td class="px-6 py-4 whitespace-nowrap exam-status">
                        @if(checkExamisExpired($exam->start_time))
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                        @else   
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="javascript:void(0);" class="view-exam text-blue-600 hover:text-blue-900 mr-4">View</a>
                         @if(!checkExamisExpired($exam->start_time))
                           <a href="#" class="edit-exam text-yellow-600 hover:text-yellow-900 mr-4">Edit</a>
                        @endif
                        <!-- <a href="#" class="text-red-600 hover:text-red-900">Import</a> -->
                    </td>
                </tr>
                    @endforeach
                <!-- More exam rows can be added here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Exam details modal -->
<div id="exam-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
    <div class="fixed inset-0 bg-black opacity-40"></div>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-2xl w-full z-10">
        <div class="p-4 border-b flex items-center justify-between">
            <h3 id="exam-modal-title" class="text-lg font-semibold">Exam Title</h3>
            <button id="exam-modal-close" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-500">Scheduled</p>
                <p id="exam-modal-start" class="text-sm text-gray-800"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Created</p>
                <p id="exam-modal-created" class="text-sm text-gray-800"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p id="exam-modal-status" class="text-sm text-gray-800"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Description</p>
                <p id="exam-modal-desc" class="text-sm text-gray-800">No description provided.</p>
            </div>
        </div>
        <div class="p-4 border-t">
            @if (checkeExamQuestionsIsEmpty($exam->id))
                <form id="import-form" action="{{ route('instructor.exam.import_questions', ['id' => $exam->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="hidden" name="exam_id" id="import-exam-id" value="">
                    <label class="block text-sm text-gray-600">Import Questions (CSV or XLSX)</label>
                    <div class="flex items-center space-x-3">
                        <input id="questions-file" name="questions_file" type="file" accept=".csv,.xlsx" class="text-sm text-gray-600" />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Import</button>
                    </div>
                    <p class="text-xs text-gray-500">Upload a CSV/XLSX file with questions. First column should be the question text. <a href="/template.csv" class="text-blue-600 hover:underline">Download template here.</a></p>
                </form>
            @else 
                 <p class="text-sm text-gray-600 mb-3">Question already imported for this exam. Download the questions file to view them.</p>
            @endif
        </div>
         <div class="p-4 border-t text-right">
            <button id="exam-modal-close-2" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Close</button>
        </div>
    </div>
</div>

<!-- edit exam modal -->
<div id="edit-exam-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
    <div class="fixed inset-0 bg-black opacity-40"></div>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-md w-full z-10">
        <div class="p-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Edit Exam Details</h3>
            <button id="edit-email-modal-close" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div class="p-6">
            <form id="edit-email-form" action="{{ route('instructor.exam.update', ['id' => $exam->id]) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Exam title</label>
                    <input type="text" name="title" id="edit-exam-title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Exam Description</label>
                    <input type="text" name="description" id="edit-exam-description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <!-- <div>
                    <label for="new-date" class="block text-sm font-medium text-gray-700">Exam Date & Time</label>
                    <input type="datetime-local" name="date" id="edit-exam-date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>  
                </div> -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                    <input type="number" name="duration" id="edit-exam-duration" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label for="marks" class="block text-sm font-medium text-gray-700">Total Marks</label>
                    <input type="number" name="marks" id="edit-exam-marks" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div class="text-right">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Exam Details</button>
                </div>
            </form>
        </div>
    </div>
</div>  


<!-- End of modal -->


@endsection
@section('scripts')
<script>
    // Show modal when clicking a view link and populate fields from the row
    document.addEventListener('click', function(e){
        if (e.target && e.target.matches('.view-exam')){
            e.preventDefault();
            const row = e.target.closest('tr');
            if (!row) return;
            const title = row.querySelector('.exam-title')?.textContent?.trim() || '';
            const start = row.querySelector('.exam-date')?.textContent?.trim() || '';
            const created = row.querySelector('.exam-created')?.textContent?.trim() || '';
            const status = row.querySelector('.exam-status')?.textContent?.trim() || '';

            // populate modal fields
            document.getElementById('exam-modal-title').textContent = title;
            document.getElementById('exam-modal-start').textContent = start;
            document.getElementById('exam-modal-created').textContent = created;
            document.getElementById('exam-modal-status').textContent = status;

            // description
            const desc = row.getAttribute('data-description') || '';
            document.getElementById('exam-modal-desc').textContent = desc || 'No description provided.';

            // set exam id for import form
            const examId = row.getAttribute('data-id') || '';
            const importExamInput = document.getElementById('import-exam-id');
            if (importExamInput) importExamInput.value = examId;

            const modal = document.getElementById('exam-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // close buttons
        if (e.target && (e.target.id === 'exam-modal-close' || e.target.id === 'exam-modal-close-2')){
            const modal = document.getElementById('exam-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            // reset import file input
            const fileInput = document.getElementById('questions-file');
            if (fileInput) fileInput.value = '';
        }
    });

    // click outside to close
    document.getElementById('exam-modal')?.addEventListener('click', function(e){
        if (e.target === this){
            this.classList.remove('flex');
            this.classList.add('hidden');
            const fileInput = document.getElementById('questions-file');
            if (fileInput) fileInput.value = '';
        }
    });
</script>
<script>
    // Add any JavaScript needed for the view exams page here
    document.addEventListener('click', function(e){
        if (e.target && e.target.matches('.edit-exam')){
            e.preventDefault();
            const row = e.target.closest('tr');
            if (!row) return;
            const examId = row.getAttribute('data-id') || '';

            // Show edit exam modal
            const modal = document.getElementById('edit-exam-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // You can populate the form with existing exam details if needed
            const title = row.querySelector('.exam-title')?.textContent?.trim() || '';
            const duration = row.querySelector('.exam-duration')?.textContent?.trim() || '';
            const marks = row.querySelector('.exam-marks')?.textContent?.trim() || '';
            const description = row.getAttribute('data-description') || '';
            // const dateText = row.getAttribute('data-date') || '';
            let dateValue = '';

            document.getElementById('edit-exam-title').value = title;
            document.getElementById('edit-exam-duration').value = duration;
            document.getElementById('edit-exam-marks').value = marks;
            document.getElementById('edit-exam-description').value = description;
            // document.getElementById('edit-exam-date').value = dateText;
            // Set form action URL
            document.getElementById('edit-exam-form').action = '/instructor/exams/' + examId + '/edit';

        }
    });

    document.getElementById('edit-exam-modal-close')?.addEventListener('click', function(){
        const modal = document.getElementById('edit-exam-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    });

</script>
@endsection
