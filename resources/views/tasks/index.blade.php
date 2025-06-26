@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Task Manager</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add Task</a>
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col">
                    <select name="user_id" class="form-control">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="status_id" class="form-control">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
            </div>
        </form>
        <div class="row">
            @foreach($statuses as $status)
                <div class="col-md-4">
                    <h3>{{ $status->name }}</h3>
                    <div class="task-column" data-status-id="{{ $status->id }}">
                        @foreach($tasks->where('status_id', $status->id) as $task)
                            <div class="card mb-2 task-card" data-task-id="{{ $task->id }}">
                                <div class="card-body">
                                    <p>{{ $task->description }}</p>
                                    @if($task->image)
                                        <img src="{{ asset('storage/' . $task->image) }}" class="img-fluid" style="max-height: 100px;">
                                    @endif
                                    <p>Assigned to: {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}</p>
                                    <p>Created: {{ $task->created_date }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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
                            }
                        });
                    }
                });
            });
        });
    </script>
    <style>
        .task-column { min-height: 100px; background: #f8f9fa; padding: 10px; }
        .task-card { cursor: move; }
    </style>
@endsection
