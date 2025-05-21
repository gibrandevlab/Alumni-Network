<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilAlumni;
use Illuminate\Http\Request;

class MemberSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profilAlumni')->where('role', 'alumni');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $alumni = $query->paginate(10);

        return view('pages.dashboard.member-setting', compact('alumni'));
    }

    public function show($id)
    {
        $alumni = User::with('profilAlumni')->where('role', 'alumni')->findOrFail($id);

        return $alumni;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:pending,approved,rejected',
            'nim' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:'.date('Y'),
            'tahun_lulus' => 'nullable|integer|min:1900|max:'.date('Y'),
            'no_telepon' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'nama' => $validated['nama'],
            'password' => bcrypt($validated['password']),
            'role' => 'alumni',
            'status' => $validated['status'],
        ]);

        $user->profilAlumni()->create($request->only([
            'nim', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
            'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
        ]));

        return response()->json($user->load('profilAlumni'), 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::with('profilAlumni')->findOrFail($id);

        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'nama' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:8',
            'status' => 'sometimes|required|in:pending,approved,rejected',
            'nim' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:'.date('Y'),
            'tahun_lulus' => 'nullable|integer|min:1900|max:'.date('Y'),
            'no_telepon' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $user->update($request->only(['email', 'nama', 'status']));
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->profilAlumni()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'nim', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
                'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
            ])
        );

        return;
    }

    public function destroy($id)
    {
        $user = User::where('role', 'alumni')->findOrFail($id);
        $user->delete();

        return;
    }
}
