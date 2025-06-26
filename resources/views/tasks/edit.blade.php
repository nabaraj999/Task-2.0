@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Task</h1>
        <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data" class="max-w-2xl mx-auto">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea
                    name="description"
                    id="description"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                    rows="5"
                    required
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (Optional)</label>
                @if($task->image)
                    <img src="{{ asset('storage/' . $task->image) }}" class="w-full h-auto max-h-24 object-cover rounded-md mb-2" alt="Current Task Image">
                @endif
                <input
                    type="file"
                    name="image"
                    id="image"
                    class="w-full border border-gray-300 rounded-lg p-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    accept="image/*"
                >
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                        <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('status_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                        <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Update Task
                </button>
                <a
                    href="{{ route('tasks.index') }}"
                    class="w-full bg-gray-600 text-white font-semibold px-4 py-3 rounded-lg hover:bg-gray-700 transition text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
