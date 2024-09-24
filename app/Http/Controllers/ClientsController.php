<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use Inertia\Inertia;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Clients/Index', [
            'page' => Client::query()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $client = new Client($request->all());
        $client->save();
        return redirect('clients');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('Clients/Create', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Client $client)
    {
        $client->update($request->all());
        return Inertia::render('Clients/Create', [
            'client' => $client,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->deleteOrFail();
        return Inertia::render('Clients/Index');
    }
}
