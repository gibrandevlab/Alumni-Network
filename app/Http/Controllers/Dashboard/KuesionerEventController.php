<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventKuesioner;
use App\Models\ResponKuesioner;
use App\Models\User;
use App\Models\PertanyaanKuesioner;
use App\Exports\ResponKuesionerExport;
use Maatwebsite\Excel\Facades\Excel;

class KuesionerEventController extends Controller
{
    public function index()
    {
        $events = EventKuesioner::orderByDesc('created_at')->get();
        foreach ($events as $event) {
            // Status logic
            $status = $event->status ?? 'active';
            $statusConfig = [
                'active' => ['class' => 'bg-green-100 text-green-800 border-green-200', 'text' => 'Aktif'],
                'completed' => ['class' => 'bg-blue-100 text-blue-800 border-blue-200', 'text' => 'Selesai'],
                'draft' => ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'text' => 'Draft']
            ];
            $currentStatus = $statusConfig[$status] ?? $statusConfig['draft'];
            $event->status_class = $currentStatus['class'];
            $event->status_text = $currentStatus['text'];

            // Progress logic
            if ($event->target_peserta === 'alumni') {
                $event->target = User::where('role', 'alumni')->where('status', 'approved')->count();
                $event->responses = ResponKuesioner::where('event_kuesioner_id', $event->id)->distinct('user_id')->count('user_id');
                $event->progress = $event->target > 0 ? min(($event->responses / $event->target) * 100, 100) : 0;
            } else {
                $event->target = null;
                $event->responses = null;
                $event->progress = null;
            }
        }
        return view('pages.dashboard.kuesioner', compact('events'));
    }

    public function create()
    {
        return view('pages.dashboard.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_event' => 'required',
            'tahun_mulai' => 'required|integer',
            'tahun_akhir' => 'required|integer',
            'deskripsi_event' => 'required',
        ]);
        EventKuesioner::create($request->only(['judul_event','tahun_mulai','tahun_akhir','deskripsi_event']));
        return redirect()->route('dashboard.kuesioner.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $event = EventKuesioner::findOrFail($id);
        return view('pages.dashboard.kuesioner.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_event' => 'required',
            'tahun_mulai' => 'required|integer',
            'tahun_akhir' => 'required|integer',
            'deskripsi_event' => 'required',
        ]);
        $event = EventKuesioner::findOrFail($id);
        $event->update($request->only(['judul_event','tahun_mulai','tahun_akhir','deskripsi_event']));
        return redirect()->route('dashboard.kuesioner.index')->with('success', 'Event berhasil diupdate.');
    }

    public function destroy($id)
    {
        $event = EventKuesioner::findOrFail($id);
        $event->delete();
        return redirect()->route('dashboard.kuesioner.index')->with('success', 'Event berhasil dihapus.');
    }

    // CRUD Pertanyaan Kuesioner per Event
    public function pertanyaanIndex($event_id)
    {
        $event = EventKuesioner::findOrFail($event_id);
        $pertanyaans = $event->pertanyaan()->orderBy('urutan')->get();
        return response()->json($pertanyaans);
    }

    public function pertanyaanStore(Request $request, $event_id)
    {
        $request->validate([
            'kategori' => 'required',
            'tipe' => 'required',
            'urutan' => 'required|integer',
            'pertanyaan' => 'required',
        ]);
        $pertanyaan = PertanyaanKuesioner::create([
            'event_kuesioner_id' => $event_id,
            'kategori' => $request->kategori,
            'tipe' => $request->tipe,
            'urutan' => $request->urutan,
            'pertanyaan' => $request->pertanyaan,
            'skala' => $request->skala ?? null,
        ]);
        return response()->json($pertanyaan, 201);
    }

    public function pertanyaanUpdate(Request $request, $event_id, $pertanyaan_id)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $event_id)->findOrFail($pertanyaan_id);
        $pertanyaan->update($request->only(['kategori','tipe','urutan','pertanyaan','skala']));
        return response()->json($pertanyaan);
    }

    public function pertanyaanDestroy($event_id, $pertanyaan_id)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $event_id)->findOrFail($pertanyaan_id);
        $pertanyaan->delete();
        return response()->json(['success' => true]);
    }

    // Download Respon Kuesioner (Excel)
    public function downloadRespon($event_id)
    {
        $event = EventKuesioner::findOrFail($event_id);
        $respon = \App\Models\ResponKuesioner::where('event_kuesioner_id', $event_id)->get();
        if ($respon->isEmpty()) {
            return back()->with('error', 'Belum ada respon kuesioner.');
        }
        // Normalisasi jawaban JSON ke array
        $rows = [];
        foreach ($respon as $r) {
            $jawaban = json_decode($r->jawaban, true);
            $row = ['user_id' => $r->user_id];
            foreach ($jawaban as $kategori => $isi) {
                if (is_array($isi)) {
                    foreach ($isi as $key => $val) {
                        if (is_array($val)) {
                            foreach ($val as $k => $v) {
                                $row[$kategori.'_'.$key.'_'.$k] = $v;
                            }
                        } else {
                            $row[$kategori.'_'.$key] = $val;
                        }
                    }
                } else {
                    $row[$kategori] = $isi;
                }
            }
            $rows[] = $row;
        }
        // Export ke Excel
        $filename = 'respon_kuesioner_event_'.$event_id.'.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ResponKuesionerExport($rows), $filename);
    }
}
