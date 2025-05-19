<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use Illuminate\Support\Facades\Auth;

class MemberSettingController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin' || Auth::user()->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function memberSetting(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $dataPengguna = $this->decryptUserData();

        if ($dataPengguna['status'] !== 'approved') {
            return redirect()->route('login')->with('error', 'Anda belum di-approve oleh admin.');
        }

        $alumniIds = ProfilAlumni::pluck('user_id')->toArray();

        $users = User::whereNotIn('id', $alumniIds)
            ->where('role', 'alumni')
            ->select('id')
            ->orderByDesc('updated_at')
            ->get();

        return view('pages.dashboard.member-setting', [
            'profil' => $this->getProfile($dataPengguna['id'], $dataPengguna['role']),
            'alumniProfiles' => $this->getPaginatedAlumniProfiles($request),
            'peranPengguna' => $dataPengguna['role'],
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:profil_alumnis,nim',
            'nama' => 'required|string|max:255',
        ]);

        ProfilAlumni::create($request->only(['nim', 'nama']));

        return response()->json(['success' => 'Data added successfully']);
    }

    public function ambilDataAlumni($id)
    {
        $alumni = ProfilAlumni::find($id);

        if (!$alumni) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
        ]);

        $alumni = ProfilAlumni::find($id);

        if (!$alumni) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $alumni->update($request->only(['nim', 'nama']));

        return response()->json(['success' => 'Data updated successfully']);
    }

    public function destroy($id)
    {
        try {
            ProfilAlumni::findOrFail($id)->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }

    private function getProfile($userId, $userRole)
    {
        return $this->getProfileModel($userRole)::select($this->getProfileColumns($userRole))
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    private function getProfileModel($role)
    {
        return $role === 'admin' ? ProfilAdmin::class : ProfilAlumni::class;
    }

    private function getProfileColumns($role)
    {
        return [
            'admin' => ['no_telepon', 'jabatan'],
            'alumni' => ['tahun_lulus', 'linkedin', 'instagram', 'no_telepon'],
        ][$role] ?? [];
    }

    private function decryptUserData()
    {
        return [
            'id' => Auth::id(),
            'role' => Auth::user()->role,
            'status' => Auth::user()->status,
        ];
    }

    private function getPaginatedAlumniProfiles(Request $request)
    {
        return ProfilAlumni::with('user:id,nama') // Eager load the user relationship and select the nama field
            ->paginate(10);
    }

    private function validateUpdateRequest(Request $request)
    {
        $request->validate($this->getUpdateValidationRules());
    }

    private function getUpdateData(Request $request)
    {
        return $request->only([
            'nim', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
            'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
        ]);
    }

    private function getStoreValidationRules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'nim' => 'required|string',
            'tahun_masuk' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'no_telepon' => 'required|string',
            'alamat_rumah' => 'nullable|string',
            'ipk' => 'nullable|numeric',
            'linkedin' => 'nullable|string',
            'instagram' => 'nullable|string',
            'email_alternatif' => 'nullable|string|email',
        ];
    }

    private function getUpdateValidationRules()
    {
        return [
            'nim' => 'nullable|string',
            'tahun_masuk' => 'nullable|integer',
            'tahun_lulus' => 'nullable|integer',
            'no_telepon' => 'nullable|string',
            'alamat_rumah' => 'nullable|string',
            'ipk' => 'nullable|numeric',
            'linkedin' => 'nullable|string',
            'instagram' => 'nullable|string',
            'email_alternatif' => 'nullable|string|email',
        ];
    }

    private function findAlumni($id)
    {
        try {
            return response()->json(ProfilAlumni::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
