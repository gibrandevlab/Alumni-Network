<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilAlumni;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilAdmin;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSettingController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin' || Auth::user()->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $userData = Auth::user();
        $users = $this->getPaginatedUsers($request);

        if ($request->ajax()) {
            return view('partials.user_table_body', compact('users'));
        }

        return view('pages.dashboard.user-setting', [
            'profil' => $this->getUserProfileName($userData->id, $userData->role),
            'peranPengguna' => $userData->role,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input termasuk file foto
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|numeric|digits:8',
            'tahun_masuk' => 'required|numeric|min:1900|max:' . date('Y'),
            'tahun_lulus' => 'required|numeric|min:1900|max:' . date('Y'),
            'no_telepon' => 'required|numeric|digits_between:8,12',
            'ipk' => 'required|numeric|min:0|max:4',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        try {
            // Proses upload foto
            if ($request->hasFile('foto')) {
                $media = $request->file('foto');
                $fileName = uniqid() . '.' . $media->getClientOriginalExtension(); // Nama unik untuk file
                $mediaPath = 'images/profiluser/' . $fileName;

                // Simpan ke direktori 'public/images/profiluser'
                Storage::disk('public')->putFileAs('images/profiluser', $media, $fileName);

                // Tambahkan path file ke data yang akan disimpan
                $validatedData['foto'] = $mediaPath;
            }

            // Simpan data pengguna
            User::create($validatedData);

            return redirect()->route('dashboard.user-setting')->with('success', 'Data pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.user-setting')->with('error', 'Gagal menambahkan data pengguna: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data, password is optional now
        $validated = $request->validate([
            'password' => 'nullable|string',  // No minimum length and password is optional
            'role' => 'required|in:admin,alumni,pencari_kerja',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            $user = User::findOrFail($id);

            // Only hash the password if a new one is provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                // Keep the existing password if not provided
                unset($validated['password']);
            }

            // Update the user with the validated data (password will be hashed if provided)
            $user->update(array_filter($validated));

            // Redirect with success message
            return redirect()->route('dashboard.user.setting.show', $id)
                ->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json(['message' => 'Data pengguna berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }

    private function getPaginatedUsers(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('role', 'alumni');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10);
    }

    private function getUserProfileName($userId, $userRole)
    {
        $model = $userRole === 'admin' ? ProfilAdmin::class : ProfilAlumni::class;
        return $model::where('user_id', $userId)->select('nama')->first() ?? (object) ['nama' => null];
    }

    private function validateRequest(Request $request, $type)
    {
        $rules = $type === 'store' ? $this->getStoreValidationRules() : $this->getUpdateValidationRules($request);
        $request->validate($rules);
    }

    private function getStoreValidationRules()
    {
        return [
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,alumni,pencari_kerja',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    private function getUpdateValidationRules(Request $request)
    {
        return [
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|in:admin,alumni,pencari_kerja',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }

    private function findUserById($id)
    {
        try {
            return response()->json(User::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
