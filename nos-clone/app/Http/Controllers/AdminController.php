<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with('role')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    public function editUser($id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'User deleted successfully');
    }
}