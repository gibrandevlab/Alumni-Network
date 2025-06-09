<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;
use Illuminate\Support\Str;

class KuesionerController extends Controller
{
    // Tampilkan halaman utama manajemen kuesioner
    public function index(Request $request)
    {
        $query = Kuesioner::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'like', "%$q%")
                    ->orWhere('deskripsi', 'like', "%$q%") ;
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $kuesioners = $query->withCount(['pertanyaan', 'respon'])->orderByDesc('created_at')->get();
        return view('pages.dashboard.kuesioner', compact('kuesioners'));
    }

    // Tampilkan form tambah kuesioner
    public function create()
    {
        return view('pages.dashboard.kuesioner-form');
    }

    // Simpan kuesioner baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun_mulai' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        $kuesioner = Kuesioner::create($validated);
        return redirect()->route('dashboard.kuesioner.edit', $kuesioner->id)->with('success', 'Kuesioner berhasil dibuat.');
    }

    // Tampilkan form edit kuesioner
    public function edit($id)
    {
        $kuesioner = Kuesioner::with('pertanyaan')->findOrFail($id);
        return view('pages.dashboard.kuesioner-form', compact('kuesioner'));
    }

    // Update kuesioner
    public function update(Request $request, $id)
    {
        $kuesioner = Kuesioner::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun_mulai' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        $kuesioner->update($validated);
        return redirect()->route('dashboard.kuesioner.edit', $kuesioner->id)->with('success', 'Kuesioner berhasil diupdate.');
    }

    // Hapus kuesioner
    public function destroy($id)
    {
        $kuesioner = Kuesioner::findOrFail($id);
        $kuesioner->delete();
        return redirect()->route('dashboard.kuesioner.index')->with('success', 'Kuesioner berhasil dihapus.');
    }

    // Tambah pertanyaan ke kuesioner
    public function addPertanyaan(Request $request, $kuesioner_id)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:likert,esai,pilihan',
            'skala' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
        ]);
        $validated['kuesioner_id'] = $kuesioner_id;
        if ($request->filled('edit_id')) {
            $pertanyaan = PertanyaanKuesioner::where('kuesioner_id', $kuesioner_id)->findOrFail($request->edit_id);
            $pertanyaan->update($validated);
            return redirect()->route('dashboard.kuesioner.edit', $kuesioner_id)->with('success', 'Pertanyaan berhasil diupdate.');
        } else {
            PertanyaanKuesioner::create($validated);
            return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
        }
    }

    // Hapus pertanyaan
    public function deletePertanyaan($kuesioner_id, $pertanyaan_id)
    {
        $pertanyaan = PertanyaanKuesioner::where('kuesioner_id', $kuesioner_id)->findOrFail($pertanyaan_id);
        $pertanyaan->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
} 