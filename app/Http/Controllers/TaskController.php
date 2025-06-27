<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['status', 'creator', 'assignee']);
        if ($request->user_id) {
            $query->where('assigned_to', $request->user_id);
        }
        if ($request->status_id) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->date) {
            $query->whereDate('created_date', $request->date);
        }
        $tasks = $query->get();
        $users = User::all();
        $statuses = Status::all();
        return view('tasks.index', compact('tasks', 'users', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'status_id' => 'required|exists:statuses,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['created_date'] = now();
        if ($request->assigned_to) {
            $data['assigned_date'] = now();
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $task = Task::create($data);
        return response()->json(['success' => true, 'message' => 'Task created successfully!', 'task' => $task->load('assignee')]);
    }

    public function edit(Task $task)
    {
        if ($task->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized to edit this task.'], 403);
        }
        return response()->json(['task' => $task->load('assignee')]);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized to edit this task.'], 403);
        }

        $request->validate([
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'status_id' => 'required|exists:statuses,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        } else {
            $data['image'] = $task->image;
        }
        $data['assigned_date'] = $request->assigned_to ? now() : null;
        $data['completed_date'] = $request->status_id == 3 ? now() : null;

        $task->update($data);
        return response()->json(['success' => true, 'message' => 'Task updated successfully!', 'task' => $task->load('assignee')]);
    }

    public function destroy(Task $task)
    {
        if ($task->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized to delete this task.'], 403);
        }

        $task->delete();
        return response()->json(['success' => true, 'message' => 'Task deleted successfully!']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->update([
            'status_id' => $request->status_id,
            'completed_date' => $request->status_id == 3 ? now() : null,
        ]);
        return response()->json(['success' => true]);
    }
}
