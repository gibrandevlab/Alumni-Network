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
    public function dashboard(Request $request)
    {
        // Pastikan user terautentikasi dan memiliki hak akses
        $this->authorizeDashboard();

        $userData = $this->getUserData();
        $profil = $this->getUserProfile($userData['id'], $userData['role']);

        $jumlahPenggunaDisetujui = User::where('status', 'approved')
            ->where('role', 'alumni')
            ->count();

        $jumlahPenggunaPending = User::where('status', 'pending')
            ->where('role', 'alumni')
            ->count();

        $jurusanDefault = $request->query('jurusandefault');

        $alumniDanResponden = $this->getAlumniAndRespondents($jurusanDefault);
        $persentasePerTahun = $this->calculatePercentagePerYear($alumniDanResponden);

        $totalAlumni = $alumniDanResponden->sum('total_alumni');
        $totalResponden = $alumniDanResponden->sum('total_responden');
        $persentaseRespondenKeseluruhan = $this->calculateOverallPercentage($totalAlumni, $totalResponden);

        // Ambil parameter filter jurusan dari request
        $jurusan1 = $request->query('jurusan1');
        $jurusan2 = $request->query('jurusan2');

        $jumlahRespondenJurusan0 = DB::table('profil_alumni')
            ->select('jurusan', DB::raw('COUNT(*) as jumlah_responden'))
            ->when($jurusanDefault, fn($query) => $query->where('jurusan', $jurusanDefault))
            ->groupBy('jurusan')
            ->get();

        $jawabanKuesioner1 = $this->getQuestionnaireResponses($jurusan1, $jurusanDefault);
        $jawabanKuesioner2 = ($jurusan1 === $jurusan2)
            ? $jawabanKuesioner1
            : $this->getQuestionnaireResponses($jurusan2, $jurusanDefault);

        return view('pages.dashboard.index', [
            'profil'                         => $profil,
            'jumlahPenggunaDisetujui'         => $jumlahPenggunaDisetujui,
            'jumlahPenggunaPending'           => $jumlahPenggunaPending,
            'peranPengguna'                   => $userData['role'],
            'persentasePerTahun'              => $persentasePerTahun,
            'persentaseRespondenKeseluruhan'   => $persentaseRespondenKeseluruhan,
            'totalResponden'                  => $totalResponden,
            'jawabanKuesioner1'               => $jawabanKuesioner1,
            'jawabanKuesioner2'               => $jawabanKuesioner2,
            'jumlahRespondenJurusan0'         => $jumlahRespondenJurusan0,
            'jurusandefault'                  => $jurusanDefault,
            'jurusan1'                      => $jurusan1,
            'jurusan2'                      => $jurusan2,
        ]);
    }

    private function authorizeDashboard(): void
    {
        // Cek apakah user sudah login dan mempunyai peran admin yang disetujui
        if (!Auth::check() || ($this->getUserData()['status'] !== 'approved') || $this->getUserData()['role'] !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    private function getUserData(): array
    {
        $user = Auth::user();
        return [
            'id'     => Auth::id(),
            'role'   => $user->role,
            'status' => $user->status,
        ];
    }

    private function getUserProfile($userId, $userRole)
    {
        $profilClass = ($userRole === 'admin') ? ProfilAdmin::class : ProfilAlumni::class;
        $columns = ($userRole === 'admin')
            ? ['nama', 'email', 'no_telepon', 'jabatan']
            : ['nama', 'tahun_lulus', 'linkedin', 'instagram', 'email', 'no_telepon'];

        return $profilClass::where('user_id', $userId)
            ->firstOrFail($columns);
    }

    private function getAlumniAndRespondents($jurusanDefault = null)
    {
        $query = ProfilAlumni::select(
            'profil_alumni.tahun_lulus',
            DB::raw('COUNT(profil_alumni.id) as total_alumni'),
            DB::raw('COUNT(DISTINCT respon_kuesioner.user_id) as total_responden')
        )
            ->leftJoin('respon_kuesioner', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->groupBy('profil_alumni.tahun_lulus');

        if ($jurusanDefault) {
            $query->where('profil_alumni.jurusan', $jurusanDefault);
        }

        return $query->get();
    }

    private function calculatePercentagePerYear($alumniAndRespondents)
    {
        return $alumniAndRespondents->transform(function ($data) {
            $data->persentase = $data->total_alumni > 0
                ? ($data->total_responden / $data->total_alumni) * 100
                : 0;
            return $data;
        });
    }

    private function calculateOverallPercentage($totalAlumni, $totalResponden)
    {
        return $totalAlumni > 0 ? ($totalResponden / $totalAlumni) * 100 : 0;
    }

    private function getQuestionnaireResponses($jurusan = null, $jurusanDefault = null): array
    {
        $responses = ResponKuesioner::with('user.profilAlumni')
            ->join('profil_alumni', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->whereNotNull('profil_alumni.jurusan')
            ->when($jurusan, fn($query) => $query->where('profil_alumni.jurusan', $jurusan))
            ->when($jurusanDefault, fn($query) => $query->where('profil_alumni.jurusan', $jurusanDefault))
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
