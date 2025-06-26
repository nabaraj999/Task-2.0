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

    public function create()
    {
        $users = User::all();
        $statuses = Status::all();
        return view('tasks.create', compact('users', 'statuses'));
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

        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
