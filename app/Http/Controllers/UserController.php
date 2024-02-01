<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user', compact('users'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->input('username'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        return redirect()->route('users.index')->with('success', '201 created');
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);


        $user->update([
            'username' => $request->input('username'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('users.index')->with('success', 'Category updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with([
            'alertColor' => 'danger',
            'success' => '204 No Content'
        ]);
    }
}
