<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:role and permission,admin'])->only('index');
        $this->middleware(['permission:role and permission create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:role and permission edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:role and permission destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'rolePermission';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Role::all();

        return view('rolePermission.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['results'] = Permission::all()->groupBy('group_name');

        return view('rolePermission.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:permissions,name|max:50'
        ]);

        if ($validator->fails()) {

            flash()->addError('Invalid Credential');

            return redirect('admin/role/create')
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);
        $role->syncPermissions($request->permissions);

        flash()->addSuccess('Role add successful');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['results'] = Permission::all()->groupBy('group_name');
        $this->data['info'] = $info = Role::findOrFail($id);
        $this->data['rolePermissions'] = $info->permissions->pluck('name')->toArray();

        return view('rolePermission.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $request->role]);

        $role->syncPermissions($request->permissions);

        flash()->addSuccess('Role update successful', 'Update');
        return redirect()->route('admin.role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') {
            flash()->addError('You can\'t delete the Super Admin', 'Error');
            return redirect()->back();
        }
        $role->delete();

        flash()->addSuccess('Role delete successful', 'Delete');
        return redirect()->back();
    }
}
