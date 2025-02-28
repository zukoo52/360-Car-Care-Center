<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiRoleController extends Controller
{
    public function getRolePermissions($id)
    {
        $role = Role::with(['branches', 'permissions'])->find($id);

        if (is_null($role)) {
            return response()->json(['message' => 'Failed to locate role!'], 404);
        } else {

            $permissions = $role->permissions()->get(['name']);
            $branches = $role->branches;

            return response()->json([
                'message' => 'Found role and related permissions!',
                'role' => $role,
                'permissions' => $permissions,
                'branches' => $branches
            ], 200);
        }
    }

    public function getAssignableRoles()
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            $roles = Role::with('branches')->get();
            return response()->json($roles, 200);
        } else {
            $roles = Role::with('branches')->where('name', '!=', 'Super Admin')->get();
            return response()->json($roles, 200);
        }
    }

    public function createNewRole(Request $request)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'unique:roles']
        ]);

        //temp solution
        $input = [
            'name' => $validated_data['name'],
            'guard_name' => 'web'
        ];

        $role = Role::create($input);

        if (is_null($role)) {
            return response()->json(['message' => 'Role Creation Failed!'], 400);
        } else {
            return response()->json(['message' => 'Role Created Successfully!'], 200);
        }
    }

    public function updateRolePermissions(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'unique:roles,name,' . $id]
        ]);

        $role = Role::find($id);

        if (is_null($role)) {
            return response()->json(['message' => 'Role Update Failed, Unable To Located Role!'], 404);
        } else {
            $role->update([
                'name' => $validated_data['name']
            ]);

            $permissions = $request->permissions;
            foreach ($permissions as $permission) {

                //gets the sub array inside permissions on each element
                $sub_array = ($permission['permissions']);
                foreach ($sub_array as $key => $value) {

                    //Construct the permission phrase based on key dynamically
                    $pm_phrase = $permission['data']['phrase'] . $key;

                    if ($value) {
                        //Add Permission
                        $role->givePermissionTo($pm_phrase);
                    } else {
                        //Remove Permission
                        $role->revokePermissionTo($pm_phrase);
                    }
                }
            }

            // Adding the assigned branches
            $branches = $request->branches;
            $role->branches()->sync($branches);

            return response()->json(['message' => 'Role Updated Successfully!'], 200);
        }
    }
}
