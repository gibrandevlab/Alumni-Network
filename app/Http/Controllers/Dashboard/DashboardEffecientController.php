<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ResponKuesioner;

class DashboardEffecientController extends Controller
{
    /**
     * Menampilkan dashboard dengan data statistik dan perhitungan dari JSON jawaban.
     */
    public function index(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            abort(403, 'Otoritas ilegal');
        }

        $user = Auth::user();

        // Hanya admin dengan status 'approved' yang dapat mengakses
        if ($user->role !== 'admin' || $user->status !== 'approved') {
            abort(403, 'Otoritas ilegal');
        }

        $peranPengguna = $user->role;

        // Menghitung data pengguna alumni
        $jumlahPenggunaDisetujui = User::where('status', 'approved')
            ->where('role', 'alumni')
            ->count();

        $jumlahPenggunaPending = User::where('status', 'pending')
            ->where('role', 'alumni')
            ->count();

        $totalAlumni = User::where('role', 'alumni')->count();
        $jumlahResponden = ResponKuesioner::count();

        $persentaseRespondenKeseluruhan = $totalAlumni > 0
            ? round(($jumlahResponden / $totalAlumni) * 100, 2)
            : 0;

        // Ambil data ResponKuesioner
        $responKuesioners = ResponKuesioner::select('created_at', 'jawaban')->get();

        // Ambil filter jurusan dari request (gunakan jurusan1 atau jurusan2)
        $filterJurusan = $request->input('jurusan1') ?: $request->input('jurusan2');
        if ($filterJurusan) {
            $responKuesioners = $responKuesioners->filter(function($item) use ($filterJurusan) {
                $decodedJawaban = json_decode($item->jawaban, true);
                return isset($decodedJawaban['jurusan']) && $decodedJawaban['jurusan'] === $filterJurusan;
            });
        }

        // Kelompokkan data respon berdasarkan tahun (dari created_at)
        $responByYear = $responKuesioners->groupBy(function ($item) {
            return $item->created_at->format('Y');
        });

        // Inisialisasi array untuk perhitungan status per tahun
        $dataPerTahun = [];
        foreach ($responByYear as $year => $responses) {
            $statusCounts = ['1' => 0, '2' => 0, '3' => 0];

            foreach ($responses as $response) {
                $decodedJawaban = json_decode($response->jawaban, true);
                $counts = $this->countStatusInJawaban($decodedJawaban);
                $statusCounts['1'] += $counts['1'];
                $statusCounts['2'] += $counts['2'];
                $statusCounts['3'] += $counts['3'];
            }
            $dataPerTahun[$year] = $statusCounts;
        }

        return view('pages.dashboard.index', compact(
            'jumlahPenggunaDisetujui',
            'jumlahPenggunaPending',
            'totalAlumni',
            'jumlahResponden',
            'persentaseRespondenKeseluruhan',
            'dataPerTahun',
            'peranPengguna'
        ));
    }

    /**
     * Menghitung jumlah status 1, 2, dan 3 dari data JSON pada kolom jawaban.
     *
     * Contoh format JSON:
     * {"status":"1","kerja_awal":"ya", ... }
     *
     * @param mixed $jawaban
     * @return array
     */
    private function countStatusInJawaban($jawaban)
    {
        $counts = ['1' => 0, '2' => 0, '3' => 0];

        if (!is_array($jawaban)) {
            return $counts;
        }

        if (isset($jawaban['status'])) {
            $status = $jawaban['status'];
            if (in_array($status, ['1', '2', '3'])) {
                $counts[$status]++;
            }
        } else {
            foreach ($jawaban as $item) {
                if (is_array($item) && isset($item['status'])) {
                    $status = $item['status'];
                    if (in_array($status, ['1', '2', '3'])) {
                        $counts[$status]++;
                    }
                }
            }
        }

        return $counts;
    }
}
