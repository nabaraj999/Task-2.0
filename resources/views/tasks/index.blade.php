@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Task Manager</h1>

        <!-- Add Task Button -->
        <button id="createTaskBtn" class="inline-block bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition mb-6">
            Add Task
        </button>

        <!-- Filter Form -->
        <form method="GET" class="mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by User</label>
                    <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                    <select name="status_id" id="status_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                    <input type="date" name="date" id="date" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('date') }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Task Columns -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($statuses as $status)
                <div class="bg-gray-100 rounded-lg p-4 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $status->name }}</h3>
                    <div class="task-column min-h-[200px]" data-status-id="{{ $status->id }}">
                        @foreach($tasks->where('status_id', $status->id) as $task)
                            <div class="task-card bg-white rounded-lg shadow-md p-4 mb-4 hover:shadow-lg transition cursor-move" data-task-id="{{ $task->id }}">
                                <p class="text-gray-700 font-medium">{{ $task->description }}</p>
                                @if($task->image)
                                    <img src="{{ asset('storage/' . $task->image) }}" class="w-full h-auto max-h-54 object-cover rounded-md mt-2" alt="Task Image">
                                @endif
                                <p class="text-sm text-gray-600 mt-2">Assigned to: {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}</p>
                                <p class="text-sm text-gray-600">Created: {{ $task->created_date }}</p>
                                <p class="text-sm text-gray-600">Assigned: {{ $task->assigned_date }}</p>
                                <p class="text-sm text-gray-600">Completed: {{ $task->completed_date }}</p>
                                @if($task->created_by === Auth::id())
                                    <div class="mt-3 flex space-x-2">
                                        <button class="edit-task-btn text-blue-600 hover:text-blue-800 text-sm font-medium" data-task-id="{{ $task->id }}">Edit</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="delete-task-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Task Modal (Create/Edit) -->
        <div id="taskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
                <h2 id="modalTitle" class="text-2xl font-bold mb-4"></h2>
                <form id="taskForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="task_id" id="task_id">
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                            rows="5"
                            required
                        ></textarea>
                        <p class="error-description text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (Optional)</label>
                        <img id="currentImage" class="w-full h-auto max-h-24 object-cover rounded-md mb-2 hidden" alt="Current Task Image">
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="w-full border border-gray-300 rounded-lg p-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            accept="image/*"
                        >
                        <p class="error-image text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="mb-6">
                        <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            name="status_id"
                            id="status_id"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <p class="error-status_id text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="mb-6">
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-2">Assign To (Optional)</label>
                        <select
                            name="assigned_to"
                            id="assigned_to"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Unassigned</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <p class="error-assigned_to text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="mb-6">
                        <label for="assigned_date" class="block text-sm font-medium text-gray-700 mb-2">Assigned Date</label>
                        <input
                            type="date"
                            name="assigned_date"
                            id="assigned_date"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                        <p class="error-assigned_date text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="mb-6">
                        <label for="completed_date" class="block text-sm font-medium text-gray-700 mb-2">Completed Date</label>
                        <input
                            type="date"
                            name="completed_date"
                            id="completed_date"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                        <p class="error-completed_date text-red-500 text-sm mt-1 hidden"></p>
                    </div>
                    <div class="flex space-x-4">
                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Save Task
                        </button>
                        <button
                            type="button"
                            id="cancelModal"
                            class="w-full bg-gray-600 text-white font-semibold px-4 py-3 rounded-lg hover:bg-gray-700 transition"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <script>
        $(document).ready(function() {
            // Toastr options
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000
            };

            // Drag-and-Drop with SortableJS
            $('.task-column').each(function() {
                new Sortable(this, {
                    group: 'shared',
                    animation: 150,
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newStatusId = evt.to.dataset.statusId;
                        const tasksInColumn = Array.from(evt.to.children).map(el => el.dataset.taskId);
                        const position = tasksInColumn.indexOf(taskId);

                        $.ajax({
                            url: '/tasks/' + taskId + '/status',
                            method: 'POST',
                            data: {
                                status_id: newStatusId,
                                position: position,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                toastr.success(response.message || 'Task status updated!');
                                location.reload(); // Refresh to update task list
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message || 'Failed to update task status.');
                            }
                        });
                    }
                });
            });

            // Open Create Task Modal
            $('#createTaskBtn').click(function() {
                $('#modalTitle').text('Create Task');
                $('#taskForm')[0].reset();
                $('#task_id').val('');
                $('#currentImage').addClass('hidden').attr('src', '');
                $('.error-description, .error-image, .error-status_id, .error-assigned_to, .error-assigned_date, .error-completed_date').addClass('hidden').text('');
                $('#taskModal').removeClass('hidden');
            });

        // Open Edit Task Modal
$(document).on('click', '.edit-task-btn', function() {
    const taskId = $(this).data('task-id');
    $.ajax({
        url: '/tasks/' + taskId + '/edit',
        method: 'GET',
        success: function(data) {
            const task = data.task; // Access the task object
            $('#modalTitle').text('Edit Task');
            $('#task_id').val(task.id || '');
            $('#description').val(task.description || '');
            $('#status_id').val(task.status_id || '');
            $('#assigned_to').val(task.assigned_to || '');

            // Format dates to YYYY-MM-DD for input type="date"
            $('#assigned_date').val(task.assigned_date ? new Date(task.assigned_date).toISOString().split('T')[0] : '');
            $('#completed_date').val(task.completed_date ? new Date(task.completed_date).toISOString().split('T')[0] : '');

            // Handle image
            if (task.image) {
                $('#currentImage').attr('src', '/storage/' + task.image).removeClass('hidden');
            } else {
                $('#currentImage').addClass('hidden').attr('src', '');
            }

            // Clear any previous error messages
            $('.error-description, .error-image, .error-status_id, .error-assigned_to, .error-assigned_date, .error-completed_date').addClass('hidden').text('');
            $('#taskModal').removeClass('hidden');
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.error || 'Failed to load task data.');
        }
    });
});
            // Handle Task Form Submission (Create/Update)
            $('#taskForm').submit(function(e) {
                e.preventDefault();
                const taskId = $('#task_id').val();
                const url = taskId ? '/tasks/' + taskId : '{{ route("tasks.store") }}';
                const method = taskId ? 'POST' : 'POST';
                const formData = new FormData(this);

                if (taskId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message || 'Task saved successfully!');
                        $('#taskModal').addClass('hidden');
                        location.reload(); // Refresh to update task list
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors || {};
                        $('.error-description, .error-image, .error-status_id, .error-assigned_to, .error-assigned_date, .error-completed_date').addClass('hidden').text('');
                        if (errors.description) $('.error-description').text(errors.description[0]).removeClass('hidden');
                        if (errors.image) $('.error-image').text(errors.image[0]).removeClass('hidden');
                        if (errors.status_id) $('.error-status_id').text(errors.status_id[0]).removeClass('hidden');
                        if (errors.assigned_to) $('.error-assigned_to').text(errors.assigned_to[0]).removeClass('hidden');
                        if (errors.assigned_date) $('.error-assigned_date').text(errors.assigned_date[0]).removeClass('hidden');
                        if (errors.completed_date) $('.error-completed_date').text(errors.completed_date[0]).removeClass('hidden');
                        toastr.error(xhr.responseJSON?.message || 'Failed to save task.');
                    }
                });
            });

            // Handle Delete Task
            $(document).on('submit', '.delete-task-form', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this task?')) return;

                const form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Task deleted successfully!');
                        location.reload(); // Refresh to update task list
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to delete task.');
                    }
                });
            });

            // Close Modal
            $('#cancelModal').click(function() {
                $('#taskModal').addClass('hidden');
            });
        });
    </script>
@endsection
