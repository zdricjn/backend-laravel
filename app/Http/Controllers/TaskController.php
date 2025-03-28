<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; 
class TaskController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($projectId);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in-progress,completed',
            'dueDate' => 'nullable|date'
        ]);

        $task = $project->tasks()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'],
            'due_date' => $validatedData['dueDate'] ?? null
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, $projectId, $taskId)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($projectId);
        $task = $project->tasks()->findOrFail($taskId);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|max:255',
            'description' => 'nullable',
            'status' => 'sometimes|in:pending,in-progress,completed',
            'dueDate' => 'nullable|date'
        ]);

        $task->update([
            'name' => $validatedData['name'] ?? $task->name,
            'description' => $validatedData['description'] ?? $task->description,
            'status' => $validatedData['status'] ?? $task->status,
            'due_date' => $validatedData['dueDate'] ?? $task->due_date
        ]);

        return response()->json($task);
    }

    public function destroy($projectId, $taskId)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($projectId);
        $task = $project->tasks()->findOrFail($taskId);
        $task->delete();

        return response()->json(null, 204);
    }
}