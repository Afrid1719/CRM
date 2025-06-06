<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Permission;
use App\Models\Resource;
use App\Models\ResourceAction;
use Illuminate\Http\Request as HttpRequest;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HttpRequest $request)
    {

        return Inertia::render('Users/Index', [
            'page' => User::query()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HttpRequest $request)
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = new User($request->all());
        $user->save();
        return redirect('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HttpRequest $request, User $user)
    {
        if ($request->user()->cannot('edit', $user)) {
            abort(404);
        }

        $actions = ResourceAction::all()->unique('name')->pluck('id', 'name')->toArray();
        $resources = Resource::with([
            'permissions' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->select(['resource_id', 'value']);
            },
            'actions' => function ($query) {
                $query->select(['name', 'value', 'resource_id']);
            }
        ])->get();

        $groupedPermissions = $resources->map(function ($resource) use ($actions) {
            $permissionsArray = $resource->permissions->pluck('value')->toArray();
            $resourcePermissions = empty($permissionsArray) ? 0 : intval($permissionsArray[0]);
            $permissions = [];
            foreach ($resource->actions as $action) {
                $permissions[$action->name] = ($resourcePermissions & $action->value) === $action->value;
            }
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'permissions' => $permissions,
            ];
        })->values();

        return Inertia::render('Users/Create', [
            'user' => $user,
            'resources' => $resources,
            'actions' => $actions,
            'permissions' => $groupedPermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->all());
        return Inertia::render('Users/Create', [
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return response()->noContent();
    }

    /**
     * Update user permissions.
     */
    public function updatePermissions(HttpRequest $request, User $user)
    {
        $request = $request->all();

        $permissions = $request['permissions'];

        // Fetch all actions for all resources in one query
        $resourceIds = collect($permissions)->pluck('id')->all();
        // This DB query can be stored in fast access cache or Redis for performance
        // as the resources and actions are not changing frequently. 
        $actions = ResourceAction::whereIn('resource_id', $resourceIds)->get()->groupBy('resource_id');

        $bulkData = [];

        foreach ($permissions as $perm) {
            $resourceId = $perm['id'];
            $permissionValue = 0;

            foreach ($perm['permissions'] as $actionName => $hasPermission) {
                if ($hasPermission) {
                    $actionValue = $actions[$resourceId]->where('name', $actionName)->first()->value ?? 0;
                    $permissionValue |= $actionValue;
                }
            }

            $bulkData[] = [
                'user_id' => $user->id,
                'resource_id' => $resourceId,
                'value' => $permissionValue,
            ];
        }

        // Perform upsert
        Permission::upsert($bulkData, ['user_id', 'resource_id'], ['value']);

        return back();
    }
}
