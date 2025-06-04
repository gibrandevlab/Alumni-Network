<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventKuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class KuesionerController extends Controller
{
    // Halaman daftar event
    public function index()
    {
        $user = Auth::user();
        $events = EventKuesioner::all();
        return view('pages.kuesioner.event-list', [
            'events' => $events,
            'id' => $user?->id ?? null,
            'role' => $user?->role ?? null,
            'status' => $user?->status ?? null,
        ]);
    }

    // Form pertanyaan dinamis
    public function showForm($event_id, Request $request)
    {
        $user = Auth::user();
        // Alumni non-approved tidak boleh lanjut
        if ($user && $user->role === 'alumni' && $user->status !== 'approved') {
            return redirect()->route('kuesioner.index')->with('error', 'Akun alumni Anda belum disetujui. Anda belum dapat mengisi kuesioner.');
        }
        // Admin approved bisa akses, tapi form harus disabled
        $isAdminApproved = $user && $user->role === 'admin' && $user->status === 'approved';
        $event = EventKuesioner::findOrFail($event_id);
        $step = $request->query('step', 'umum');
        $sessionKey = 'kuesioner_' . $event_id;
        $jawaban = Session::get($sessionKey, []);

        if ($step === 'umum') {
            $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $event_id)
                ->where('kategori', 'umum')->orderBy('urutan')->first();
            return view('pages.kuesioner.form-umum', compact('event', 'pertanyaan', 'jawaban', 'isAdminApproved'));
        }
        // Step kategori: ambil jawaban umum (P1)
        $kategori = $jawaban['umum']['P1'] ?? null;
        if (!$kategori) {
            return redirect()->route('kuesioner.form', ['event_id' => $event_id, 'step' => 'umum']);
        }
        // Mapping kategori dari jawaban ke kategori tabel
        $mapKategori = [
            'bekerja' => 'bekerja',
            'melanjutkan pendidikan' => 'pendidikan',
            'lainnya' => 'lainnya',
        ];
        $kategoriKey = $mapKategori[strtolower($kategori)] ?? strtolower($kategori);
        $likert = PertanyaanKuesioner::where('event_kuesioner_id', $event_id)
            ->where('kategori', $kategoriKey)->where('tipe', 'likert')->orderBy('urutan')->get();
        $esai = PertanyaanKuesioner::where('event_kuesioner_id', $event_id)
            ->where('kategori', $kategoriKey)->where('tipe', 'esai')->orderBy('urutan')->get();
        return view('pages.kuesioner.form-kategori', compact('event', 'likert', 'esai', 'jawaban', 'kategori', 'isAdminApproved'));
    }

    // Submit jawaban
    public function submit($event_id, Request $request)
    {
        $event = EventKuesioner::findOrFail($event_id);
        $sessionKey = 'kuesioner_' . $event_id;
        $step = $request->input('step');
        $jawaban = Session::get($sessionKey, []);

        if ($step === 'umum') {
            $jawaban['umum'] = [
                'P1' => $request->input('P1')
            ];
            Session::put($sessionKey, $jawaban);
            return redirect()->route('kuesioner.form', ['event_id' => $event_id, 'step' => 'kategori']);
        }
        // Step kategori
        $kategori = strtolower($jawaban['umum']['P1'] ?? '');
        $likert = $request->input('likert', []);
        $esai = $request->input('esai', []);
        $jawaban[$kategori] = [
            'likert' => $likert,
            'esai' => $esai
        ];
        // Simpan ke DB
        ResponKuesioner::create([
            'event_kuesioner_id' => $event_id,
            'user_id' => Auth::id(),
            'jawaban' => json_encode($jawaban)
        ]);
        Session::forget($sessionKey);
        return view('pages.kuesioner.terima-kasih', compact('event'));
    }
}
