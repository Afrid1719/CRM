<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cannot('viewAny', Task::class)) {
            abort(403, "You do not have permission to view tasks.");
        }

        return Inertia::render('Tasks/Index', [
            'page' => Task::with('project', 'user', 'client')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Task::class)) {
            abort(403, "You do not have permission to create tasks.");
        }

        return Inertia::render('Tasks/Create', [
            'users' => User::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if (auth()->user()->cannot('create', Task::class)) {
            abort(403, "Unauthorized action.");
        }

        $task = Task::create($request->all());
        $task->save();
        return redirect('tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if (auth()->user()->cannot('view', $task)) {
            abort(403, "You do not have permission to view this task.");
        }

        return redirect("tasks/{$task->id}/edit");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (auth()->user()->cannot('edit', $task)) {
            abort(403, "You do not have permission to edit this task.");
        }

        return Inertia::render('Tasks/Create', [
            'users' => User::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
            'task' => $task->load('attachments'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            abort(403, "Unauthorized action.");
        }

        $data = $request->only(['title', 'description', 'assigned_to', 'for_client', 'related_to_project']);
        $data['status'] = filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN);

        $task->update($data);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->storeAs('uploads', $file->getClientOriginalName());
                    $task->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                    ]);
                }
            }
        }

        return Inertia::render("Tasks/Create", [
            'users' => User::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
            'task' => $task->load('attachments'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (auth()->user()->cannot('delete', $task)) {
            abort(403, "Unauthorized action.");
        }

        $task->deleteOrFail();
        return Inertia::render("Tasks/Index");
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            abort(403, "Unauthorized action.");
        }

        $task->update(['status' => $request->status]);
        return Inertia::render("Tasks/Index");
    }
}
