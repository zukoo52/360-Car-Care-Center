<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ITImage;

class ApiUserController extends Controller
{
    public function index(Request $request)
    {

        $auth_user =  auth('sanctum')->user();

        if (is_null($auth_user)) return response()->json(['message' => "Unable to locate user!"], 404);

        $users = User::query();

        // Check if current user is a superuser
        if (!$auth_user->hasRole('Super Admin')) {
            $users->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'Super Admin');
            });
        }

        if ($keyword = $request->get("keyword")) {
            $users->where('email', 'like', '%' . $keyword . '%')->orWhere('username', 'like', '%' . $keyword . '%');
        }

        $users->with('roles');

        if ($limit = $request->get("limit")) {
            return response()->json($users->paginate($limit));
        }

        return response()->json($users->get());
    }

    public function show($id)
    {
        $user = User::with(['roles', 'image'])->find($id);
        if (is_null($user)) return response()->json(['message' => 'Failed to locate the user! Not found!'], 404);

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        // return $request;

        $validated_data = $request->validate([
            'role_id' => ['required'],
            'username' => ['required', 'unique:users', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $role = Role::find($validated_data['role_id']);

        if (is_null($role)) {
            return response()->json(['message' => 'Failed to get role!'], 404);
        }

        $user = User::create([
            'username' => $validated_data['username'],
            'email' => $validated_data['email'],
            'password' => $validated_data['password'],
            'is_active' => true
        ]);
        $user->syncRoles($role);

        $has_photo = $request->photo['file'];
        if ($has_photo) {
            $name = time() . explode('.', $request->photo['name'])[0]  . '.' . explode('/', explode(':', substr($request->photo['file'], 0, strpos($request->photo['file'], ';')))[1])[1];
            ITImage::make($request->photo['file'])->fit(600, 600, function ($constraint) {
                $constraint->upsize();
            })->save(storage_path('app/public/images/') . $name);

            $user->image()->create([
                'path' => $name
            ]);
        }

        return response()->json(['message' => 'User added successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        if ($only = $request->get('only')) {
            switch ($only) {
                case 'image':
                    $validated_data = $request->validate([
                        'image.file' => ['required'],
                        'image.name' => ['required']
                    ]);

                    $user = User::with(['image'])->find($id);
                    if (is_null($user)) return response()->json(['message' => 'Failed to locate the user! Not found!'], 404);

                    if ($user->image != null) $user->image->delete();


                    $name = time() . explode('.', $validated_data['image']['name'])[0]  . '.' . explode('/', explode(':', substr($validated_data['image']['file'], 0, strpos($validated_data['image']['file'], ';')))[1])[1];
                    ITImage::make($validated_data['image']['file'])->fit(600, 600, function ($constraint) {
                        $constraint->upsize();
                    })->save(storage_path('app/public/images/') . $name);

                    $image = $user->image()->create([
                        'path' => $name
                    ]);

                    if (!$image) return response()->json(['message' => 'Failed to update the image, please try again!'], 500);
                    return response()->json(['message' => 'Profile image updated successfully!'], 200);

                case 'simpleUpdate':

                    $validated_data = $request->validate([
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
                        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                        'current_password' => ['required', 'string', 'min:8'],
                        'username' => ['required']
                    ]);

                    if (Auth::guard('web')->attempt(['username' => $validated_data['username'], 'password' => $validated_data['current_password']], false, false)) {

                        $user = User::find($id);
                        $user->email = $validated_data['email'];

                        if ($request->password != null) {
                            $user->password = $validated_data['password'];
                        }

                        $user->save();

                        if (is_null($user)) {
                            return response()->json(['message' => 'Failed to update user!'], 400);
                        } else {
                            return response()->json(['message' => 'User updated successfully!'], 200);
                        }
                    } else {
                        // invalid credentials, act accordingly
                        return  response()->json(['message' => 'Unable to update, authentication failed!'], 400);
                    }

                default:
                    return response()->json(['message' => 'Invalid ONLY type parameter!'], 400);
            }
        }

        $validated_data = $request->validate([
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'is_active' => ['required'],
            'role_id' => ['required'],
            'reset_password' => ['required']
        ]);

        $user = User::find($id);

        $user->username = $validated_data['username'];
        $user->email = $validated_data['email'];
        $user->is_active = $validated_data['is_active'];

        if ($validated_data['reset_password']) {
            $user->password = 'password';
        }
        $user->save();

        $role = Role::find($validated_data['role_id']);
        $user->syncRoles($role);


        if (is_null($user)) return response()->json(['message' => 'Failed to update user!'], 400);

        return response()->json(['message' => 'User updated successfully!'], 200);
    }

    public function destroy($id)
    { }
}
