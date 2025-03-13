<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('roles.index', [
            'roles' => Role::orderBy('id','DESC')->paginate(3)
        ]);
    }

    public function create()
    {
        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')
            ->withSuccess('New role is added successfully.');
    }

    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
            ->where("role_id",$role->id)
            ->select('name')
            ->get();
        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function edit(Role $role)
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }
        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();
        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $input = $request->only('name');
        $role->update($input);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);
        return redirect()->back()
            ->withSuccess('Role is updated successfully.');
    }

    public function destroy(Role $role)
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
            ->withSuccess('Role is deleted successfully.');
    }
}
