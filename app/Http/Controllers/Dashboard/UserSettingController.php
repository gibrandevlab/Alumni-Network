<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('pages.dashboard.user-setting', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return $user;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,alumni',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'nama' => $validated['nama'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'nama' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'sometimes|required|in:admin,alumni',
            'status' => 'sometimes|required|in:pending,approved,rejected',
        ]);

        $user->update($request->only(['email', 'nama', 'role', 'status']));
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return;
    }
}
