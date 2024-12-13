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
        if ($error = $this->subMainProcess()) {
            return redirect()->route('login')->with('error', $error);
        }

        $dataPengguna = $this->dekripsiDataPengguna();
        $profil = $this->ambilProfil($dataPengguna['id'], $dataPengguna['role']);
        $jumlahPenggunaDisetujui = User::where('status', 'approved')->where('role', 'alumni')->count();
        $jumlahPenggunaPending = User::where('status', 'pending')->where('role', 'alumni')->count();

        $alumniDanResponden = $this->ambilAlumniDanResponden($request->query('jurusandefault')); // Pass the 'jurusandefault' parameter
        $persentasePerTahun = $this->hitungPersentasePerTahun($alumniDanResponden);
        $totalAlumni = $alumniDanResponden->sum('total_alumni');
        $totalResponden = $alumniDanResponden->sum('total_responden');
        $persentaseRespondenKeseluruhan = $this->hitungPersentaseKeseluruhan($totalAlumni, $totalResponden);

        [$jurusandefault, $jurusan1, $jurusan2] = $this->ambilParameterJurusan($request);

        $jumlahRespondenJurusan0 = DB::table('profil_alumni')
            ->select('jurusan', DB::raw('COUNT(*) as jumlah_responden'))
            ->when($jurusandefault, function ($query) use ($jurusandefault) {
                return $query->where('jurusan', $jurusandefault); // Filter by jurusan if jurusandefault is provided
            })
            ->groupBy('jurusan')
            ->get();

        $jawabanKuesioner1 = $this->jawabanKuesioner($jurusan1, $jurusandefault);
        $jawabanKuesioner2 = ($jurusan1 == $jurusan2) ? $jawabanKuesioner1 : $this->jawabanKuesioner($jurusan2, $jurusandefault);


        return view('pages.dashboard.index', [
            'profil' => $profil,
            'jumlahPenggunaDisetujui' => $jumlahPenggunaDisetujui,
            'jumlahPenggunaPending' => $jumlahPenggunaPending,
            'peranPengguna' => $dataPengguna['role'],
            'persentasePerTahun' => $persentasePerTahun,
            'persentaseRespondenKeseluruhan' => $persentaseRespondenKeseluruhan,
            'totalResponden' => $totalResponden,
            'jawabanKuesioner1' => $jawabanKuesioner1,
            'jawabanKuesioner2' => $jawabanKuesioner2,
            'jumlahRespondenJurusan0' => $jumlahRespondenJurusan0,
            'jurusandefault' => $jurusandefault,
            'jurusan1' => $jurusan1,
            'jurusan2' => $jurusan2,
        ]);
    }


    private function ambilParameterJurusan(Request $request): array
    {
        $jurusandefault = $request->query('jurusandefault');
        $jurusan1 = $request->query('jurusan1');
        $jurusan2 = $request->query('jurusan2');

        return [$jurusandefault, $jurusan1, $jurusan2];
    }

    private function jawabanKuesioner($jurusan = null)
    {
        // Mengambil respon kuesioner dengan join dan filter jurusan jika ada
        $responKuesioner = ResponKuesioner::with('user.profilAlumni')
            ->join('profil_alumni', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->whereNotNull('profil_alumni.jurusan')
            ->when($jurusan, function ($query) use ($jurusan) {
                $query->where('profil_alumni.jurusan', $jurusan);
            })
            ->get();

        // Inisialisasi data alumni
        $dataAlumni = [];

        // Proses data respon kuesioner dan grup berdasarkan tahun lulus dan status
        foreach ($responKuesioner as $respon) {
            $profilAlumni = $respon->user->profilAlumni;

            if ($profilAlumni && $profilAlumni->tahun_lulus) {
                $tahunLulus = $profilAlumni->tahun_lulus;
                $jawaban = json_decode($respon->jawaban, true);

                // Pastikan jawaban 'status' ada sebelum memproses
                if (isset($jawaban['status'])) {
                    // Inisialisasi jika tahun lulus belum ada
                    if (!isset($dataAlumni[$tahunLulus])) {
                        $dataAlumni[$tahunLulus] = ['status_1' => 0, 'status_2' => 0, 'status_3' => 0];
                    }

                    // Perbarui hitungan status
                    $statusKey = 'status_' . $jawaban['status'];
                    if (array_key_exists($statusKey, $dataAlumni[$tahunLulus])) {
                        $dataAlumni[$tahunLulus][$statusKey]++;
                    }
                }
            }
        }

        return $dataAlumni;
    }


    private function subMainProcess()
    {
        if (!Auth::check() || ($dataPengguna = $this->dekripsiDataPengguna())['status'] !== 'approved' || $dataPengguna['role'] !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return null;
    }

    private function ambilProfil($idPengguna, $peranPengguna)
    {
        $profilClass = ($peranPengguna === 'admin') ? ProfilAdmin::class : ProfilAlumni::class;
        $kolom = ($peranPengguna === 'admin')
            ? ['nama', 'email', 'no_telepon', 'jabatan']
            : ['nama', 'tahun_lulus', 'linkedin', 'instagram', 'email', 'no_telepon'];

        return $profilClass::where('user_id', $idPengguna)
            ->firstOrFail($kolom);
    }

    private function ambilAlumniDanResponden($jurusandefault = null)
    {
        $query = ProfilAlumni::select(
            'profil_alumni.tahun_lulus',
            DB::raw('COUNT(profil_alumni.id) as total_alumni'),
            DB::raw('COUNT(DISTINCT respon_kuesioner.user_id) as total_responden')
        )
            ->leftJoin('respon_kuesioner', 'profil_alumni.user_id', '=', 'respon_kuesioner.user_id')
            ->groupBy('profil_alumni.tahun_lulus');

        if ($jurusandefault) {
            $query->where('profil_alumni.jurusan', $jurusandefault);
        }

        return $query->get();
    }

    private function hitungPersentasePerTahun($alumniDanResponden)
    {
        return $alumniDanResponden->transform(function ($data) {
            $data->persentase = $data->total_alumni ? ($data->total_responden / $data->total_alumni) * 100 : 0;
            return $data;
        });
    }

    private function hitungPersentaseKeseluruhan($totalAlumni, $totalResponden)
    {
        return $totalAlumni ? ($totalResponden / $totalAlumni) * 100 : 0;
    }

    private function dekripsiDataPengguna()
    {
        return [
            'id' => Auth::id(),
            'role' => Auth::user()->role,
            'status' => Auth::user()->status,
        ];
    }
}
