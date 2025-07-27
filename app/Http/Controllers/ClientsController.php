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
        if ($request->user()->cannot('viewAny', Client::class)) {
            abort(403, "You do not have permission to view clients.");
        }

        $query = Client::query();

        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $activeQuery = $request->input('active');

        if ($activeQuery == 'active' || $activeQuery == '') {
            $query->active();
        } elseif ($activeQuery == 'inactive') {
            $query->inactive();
        }

        return Inertia::render('Clients/Index', [
            'page' => $query->paginate(10)->withQueryString(),
            'filters' => [
                'search' => $request->input('search', ''),
                'active' => $request->input('active', 'active'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Client::class)) {
            abort(403, "You do not have permission to create clients.");
        }

        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($request->user()->cannot('create', Client::class)) {
            abort(403, "Unauthorized action.");
        }

        $client = new Client($request->all());
        $client->save();
        return redirect('clients');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Client $client)
    {
        if ($request->user()->cannot('view', $client)) {
            abort(403, "You do not have permission to view this client.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Client $client)
    {
        if ($request->user()->cannot('update', $client)) {
            abort(403, "You do not have permission to edit this client.");
        }

        return Inertia::render('Clients/Create', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Client $client)
    {
        if ($request->user()->cannot('update', $client)) {
            abort(403, "Unauthorized action.");
        }

        $client->update($request->all());
        return Inertia::render('Clients/Create', [
            'client' => $client,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Client $client)
    {
        if ($request->user()->cannot('delete', $client)) {
            abort(403, "Unauthorized action.");
        }

        $client->deleteOrFail();
        return Inertia::render('Clients/Index');
    }

    public function activation(ClientActivationRequest $request, Client $client)
    {
        if ($request->user()->cannot('edit', $client)) {
            abort(403, "Unauthorized action.");
        }

        $client->is_active = $request->isActive;
        $client->save(); // $client->update(['is_active' => $request->isActive]) did not work
        return Inertia::render('Clients/Index');
    }
}
