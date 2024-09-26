<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\AppUser;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'page' => Task::with('project', 'user', 'client')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tasks/Create', [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $task = Task::create($request->all());
        logger($task);
        $task->save();
        return redirect('tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Create', [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return Inertia::render("Tasks/Create", [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->deleteOrFail();
        return Inertia::render("Tasks/Index");
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $task->update(['status' => $request->status]);
        return Inertia::render("Tasks/Index");
    }
}
