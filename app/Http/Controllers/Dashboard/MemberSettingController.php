<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfilAlumni;
use Illuminate\Support\Facades\Auth;

class MemberSettingController extends Controller
{
    private function checkAdminAccess()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin' || $user->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }
    }

    // List alumni dengan pagination dan search
    public function index(Request $request)
    {
        $this->checkAdminAccess();

        $query = ProfilAlumni::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'alumni'));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2->where('nama', 'like', "%{$search}%"))
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $alumniProfiles = $query->orderByDesc('updated_at')->paginate(10)->withQueryString();

        return view('pages.dashboard.member-setting', [
            'alumniProfiles' => $alumniProfiles,
            'search' => $request->search,
        ]);
    }

    // Tampilkan detail alumni berdasarkan id profil_alumni
    public function show($id)
    {
        $this->checkAdminAccess();

        $alumni = ProfilAlumni::with('user:id,nama,email')->find($id);

        if (!$alumni) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($alumni);
    }

    // Simpan data alumni baru
    public function store(Request $request)
    {
        $this->checkAdminAccess();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|string|max:20|unique:profil_alumnis,nim',
            'tahun_masuk' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'no_telepon' => 'required|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $user = User::find($request->user_id);
        if (!$user || $user->role !== 'alumni') {
            return response()->json(['error' => 'User tidak valid atau bukan alumni'], 400);
        }

        if (ProfilAlumni::where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Profil alumni untuk user ini sudah ada'], 400);
        }

        ProfilAlumni::create($request->only([
            'user_id', 'nim', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
            'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
        ]));

        return response()->json(['success' => 'Data alumni berhasil ditambahkan']);
    }

    // Update data alumni
    public function update(Request $request, $id)
    {
        $this->checkAdminAccess();

        $request->validate([
            'nim' => 'required|string|max:20|unique:profil_alumnis,nim,' . $id,
            'tahun_masuk' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'no_telepon' => 'required|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $alumni = ProfilAlumni::find($id);
        if (!$alumni) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $alumni->update($request->only([
            'nim', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
            'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
        ]));

        return response()->json(['success' => 'Data alumni berhasil diperbarui']);
    }

    // Hapus data alumni
    public function destroy($id)
    {
        $this->checkAdminAccess();

        try {
            $alumni = ProfilAlumni::findOrFail($id);
            $alumni->delete();

            return response()->json(['success' => 'Data alumni berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
