@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Task Manager</h1>

        <!-- Add Task Button -->
        <a href="{{ route('tasks.create') }}" class="inline-block bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition mb-6">
            Add Task
        </a>

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
                            <div class="task-card bg-white rounded-lg shadow-md p-4 mb-4 hover:shadow-lg transition cursor-move">
                                <p class="text-gray-700 font-medium">{{ $task->description }}</p>
                                @if($task->image)
                                    <img src="{{ asset('storage/' . $task->image) }}" class="w-full h-auto max-h-24 object-cover rounded-md mt-2" alt="Task Image">
                                @endif
                                <p class="text-sm text-gray-600 mt-2">Assigned to: {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}</p>
                                <p class="text-sm text-gray-600">Created: {{ $task->created_date }}</p>
                                @if($task->created_by === Auth::id())
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
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
    </div>

    <!-- Scripts for Drag-and-Drop -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.task-column').each(function() {
                new Sortable(this, {
                    group: 'shared',
                    animation: 150,
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newStatusId = evt.to.dataset.statusId;
                        $.ajax({
                            url: '/tasks/' + taskId + '/status',
                            method: 'POST',
                            data: {
                                status_id: newStatusId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert('Task status updated!');
                            },
                            error: function() {
                                alert('Failed to update task status.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
