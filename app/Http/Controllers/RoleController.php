<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleEditRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Search for roles based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('roles.index');
        }

        $roles = Role::where('role', 'LIKE', "%{$search}%")
            ->paginate(10);

        if ($roles->isEmpty()) {
            return view('admin.role', compact('roles'));
        }

        return view('admin.role', compact('roles', 'search'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        // Create a new role
        $role = new Role();
        $role->role = $request->role;
        $role->functionalities = $request->functionalities;
        $role->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Role created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleEditRequest $request, Role $role)
    {
        // Update role data
        $role->role = $request->edit_role;
        $role->functionalities = $request->edit_functionalities;
        $role->save();

        // Redirect to roles index page with a success message
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
