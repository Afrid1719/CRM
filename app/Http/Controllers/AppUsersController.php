<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppUser\StoreRequest;
use App\Http\Requests\AppUser\UpdateRequest;
use Inertia\Inertia;

class AppUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('AppUsers/Index', [
            'page' => AppUser::query()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AppUsers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = new AppUser($request->all());
        $user->save();
        return redirect('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(AppUser $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppUser $user)
    {
        return Inertia::render('AppUsers/Create', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, AppUser $user)
    {
        $user->update($request->all());
        return Inertia::render('AppUsers/Create', [
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppUser $user)
    {
        $user->deleteOrFail();
        return response()->noContent();
    }
}
