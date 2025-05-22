<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use App\Models\ResponKuesioner;

class DashboardController extends Controller
{
    // Gunakan middleware auth standar
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        // Otorisasi admin approved
        if ($user->role !== 'admin' || $user->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }
        $profil = $this->getUserProfile($user);

        // Ambil statistik alumni dan responden per tahun (sekali query)
        $jurusanDefault = $request->query('jurusandefault');
        $alumniStats = $this->getAlumniStats($jurusanDefault);

        // Hitung total dan persentase
        $totalAlumni = $alumniStats->sum('total_alumni');
        $totalResponden = $alumniStats->sum('total_responden');
        $persentasePerTahun = $alumniStats->map(function ($row) {
            $row->persentase = $row->total_alumni > 0 ? ($row->total_responden / $row->total_alumni) * 100 : 0;
            return $row;
        });
        $persentaseRespondenKeseluruhan = $totalAlumni > 0 ? ($totalResponden / $totalAlumni) * 100 : 0;

        // Statistik pengguna
        $jumlahPenggunaDisetujui = User::where('status', 'approved')->where('role', 'alumni')->count();
        $jumlahPenggunaPending = User::where('status', 'pending')->where('role', 'alumni')->count();

        // Statistik responden per jurusan
        $jumlahRespondenJurusan0 = ProfilAlumni::select('jurusan', DB::raw('COUNT(*) as jumlah_responden'))
            ->when($jurusanDefault, fn($q) => $q->where('jurusan', $jurusanDefault))
            ->groupBy('jurusan')
            ->get();

        // Jawaban kuesioner (per jurusan)
        $jurusan1 = $request->query('jurusan1');
        $jurusan2 = $request->query('jurusan2');
        $jawabanKuesioner1 = $this->getStatusKuesionerByTahun($jurusan1 ?: $jurusanDefault);
        $jawabanKuesioner2 = ($jurusan1 === $jurusan2)
            ? $jawabanKuesioner1
            : $this->getStatusKuesionerByTahun($jurusan2 ?: $jurusanDefault);

        // Kirim data ke blade (struktur tetap sama)
        return view('pages.dashboard.index', [
            'profil' => $profil,
            'jumlahPenggunaDisetujui' => $jumlahPenggunaDisetujui,
            'jumlahPenggunaPending' => $jumlahPenggunaPending,
            'peranPengguna' => $user->role,
            'persentasePerTahun' => $persentasePerTahun,
            'persentaseRespondenKeseluruhan' => $persentaseRespondenKeseluruhan,
            'totalResponden' => $totalResponden,
            'jawabanKuesioner1' => $jawabanKuesioner1,
            'jawabanKuesioner2' => $jawabanKuesioner2,
            'jumlahRespondenJurusan0' => $jumlahRespondenJurusan0,
            'jurusandefault' => $jurusanDefault,
            'jurusan1' => $jurusan1,
            'jurusan2' => $jurusan2,
        ]);
    }

    // Ambil profil user (admin/alumni)
    private function getUserProfile($user)
    {
        if ($user->role === 'admin') {
            return ProfilAdmin::where('user_id', $user->id)->first();
        }
        return ProfilAlumni::where('user_id', $user->id)->first();
    }

    // Statistik alumni & responden per tahun (gabungan)
    private function getAlumniStats($jurusan = null)
    {
        return ProfilAlumni::select(
            'tahun_lulus',
            DB::raw('COUNT(profil_alumni.id) as total_alumni'),
            DB::raw('COUNT(DISTINCT respon_kuesioner.user_id) as total_responden')
        )
            ->leftJoin('respon_kuesioner', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->when($jurusan, fn($q) => $q->where('profil_alumni.jurusan', $jurusan))
            ->groupBy('tahun_lulus')
            ->get();
    }

    // Statistik status kuesioner per tahun lulus
    private function getStatusKuesionerByTahun($jurusan = null): array
    {
        $responses = ResponKuesioner::with('user.profilAlumni')
            ->join('profil_alumni', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->whereNotNull('profil_alumni.jurusan')
            ->when($jurusan, fn($q) => $q->where('profil_alumni.jurusan', $jurusan))
            ->get();

        $dataAlumni = [];
        foreach ($responses as $response) {
            $profilAlumni = $response->user->profilAlumni;
            if ($profilAlumni && $profilAlumni->tahun_lulus) {
                $tahunLulus = $profilAlumni->tahun_lulus;
                $jawaban = json_decode($response->jawaban, true);
                if (isset($jawaban['status'])) {
                    if (!isset($dataAlumni[$tahunLulus])) {
                        $dataAlumni[$tahunLulus] = ['status_1' => 0, 'status_2' => 0, 'status_3' => 0];
                    }
                    $statusKey = 'status_' . $jawaban['status'];
                    if (array_key_exists($statusKey, $dataAlumni[$tahunLulus])) {
                        $dataAlumni[$tahunLulus][$statusKey]++;
                    }
                }
            }
        }
        return $dataAlumni;
    }
}
