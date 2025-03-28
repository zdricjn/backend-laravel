<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; 

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects;
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'nullable|in:pending,in-progress,completed'
        ]);

        $project = Auth::user()->projects()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'] ?? 'pending'
        ]);

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'nullable',
            'status' => 'nullable|in:pending,in-progress,completed'
        ]);

        $project->update([
            'title' => $validatedData['title'] ?? $project->title,
            'description' => $validatedData['description'] ?? $project->description,
            'status' => $validatedData['status'] ?? $project->status
        ]);

        return response()->json($project);
    }

    public function destroy($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        $project->delete();

        return response()->json(null, 204);
    }

    public function tasks($projectId)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($projectId);
        $tasks = $project->tasks;

        return response()->json($tasks);
    }
}