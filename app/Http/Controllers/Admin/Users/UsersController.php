<?php

namespace App\Http\Controllers\Admin\Users;

use App\DB\System\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $roles = Role::all();

        return view('admin.users')->with([
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function add(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => [
                'required', 'email',
                Rule::unique('users')
            ],
            'role_id' => 'required',
            'password' => 'required',
        ], [
            'name.required' => "Please enter the user name",
            'email.required' => "Please enter the user email",
            'email.unique' => "This email is already taken",
            'role_id.required' => "Please select the user's role",
            'password.required' => "Please enter the users password",
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role_id' => $request['role_id'],
            'password' => Hash::make($request['password'])
        ]);

        session()->flash("success", "Successfully added user");

        return redirect()->route('users');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($request['user_id'])
            ],
            'role_id' => 'required',
        ], [
            'name.required' => "Please enter the user name",
            'email.required' => "Please enter the user email",
            'email.unique' => "This email is already taken",
            'role_id.required' => "Please select the user's role",
        ]);

        //find the user
        if(!$user = User::find($request['user_id'])){
            return back()->withErrors("User not found");
        }

        //update details
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->role_id = $request['role_id'];
        $user->password = !empty($request['password']) ? $request['password'] : $user->password;
        $user->save();

        session()->flash("success", "Successfully updated user");

        return redirect()->route('users');
    }

    public function delete(Request $request)
    {
        $validation = $request->validate([
            'user_id' => 'required',
        ]);

        //find the user
        if(!$user = User::find($request['user_id'])){
            return back()->withErrors("User not found");
        }

        //delete the user
        $user->delete();

        session()->flash("success", "Successfully deleted user");

        return redirect()->route('users');
    }
}
