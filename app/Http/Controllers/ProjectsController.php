<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\AppUser;
use App\Models\Client;
use Inertia\Inertia;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'page' => Project::with('client', 'user')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/Create', [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $project = new Project($request->all());
        $project->save();
        return redirect('projects');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Create', [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $project->update($request->all());
        return Inertia::render('Projects/Create', [
            'users' => AppUser::select('id', 'name')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'project' => $project,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->deleteOrFail();
        return Inertia::render('Projects/Index');
    }
}
