<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Http\Requests\Client\ClientActivationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($activeQuery = $request->input('active')) {
            if ($activeQuery == 'active') {
                $query->active();
            } elseif ($activeQuery == 'inactive') {
                $query->inactive();
            }
        }

        return Inertia::render('Clients/Index', [
            'page' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only('search', 'active')
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

    public function activation(ClientActivationRequest $request, Client $client)
    {
        $client->is_active = $request->isActive;
        $client->save(); // $client->update['is_active' => $request->isActive] did not work
        return Inertia::render('Clients/Index');
    }
}
