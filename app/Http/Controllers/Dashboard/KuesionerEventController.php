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
            'tahun_lulusan' => 'required|integer',
            'deskripsi_event' => 'required',
            'target_peserta' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            // Pertanyaan umum
            'kategori_umum' => 'required|in:umum',
            'tipe_umum' => 'required',
            'urutan_umum' => 'required|integer',
            'pertanyaan_umum' => 'required',
            // skala_umum boleh kosong/null
        ]);

        \DB::beginTransaction();
        try {
            // Simpan event
            $eventData = $request->only(['judul_event','tahun_mulai','tahun_akhir','tahun_lulusan','deskripsi_event','target_peserta']);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $fileName);
                $eventData['foto'] = '/images/' . $fileName;
            }
            $event = EventKuesioner::create($eventData);

            // Simpan pertanyaan umum
            $skala = $request->input('skala_umum');
            $tipe = $request->input('tipe_umum');
            if ($tipe === 'esai') {
                $skalaVal = null;
            } else {
                // Jika string json, decode
                if (is_string($skala)) {
                    $skalaVal = json_decode($skala, true);
                } else {
                    $skalaVal = $skala;
                }
            }
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $event->id,
                'kategori' => 'umum',
                'tipe' => $tipe,
                'urutan' => $request->input('urutan_umum', 1),
                'pertanyaan' => $request->input('pertanyaan_umum'),
                'skala' => $skalaVal,
            ]);
            \DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'judul_event' => 'required',
            'tahun_mulai' => 'required|integer',
            'tahun_akhir' => 'required|integer',
            'deskripsi_event' => 'required',
        ]);
        $event = EventKuesioner::findOrFail($request->event_id);
        $event->update($request->only(['judul_event','tahun_mulai','tahun_akhir','deskripsi_event','target_peserta','foto','tahun_lulusan']));
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $event = EventKuesioner::findOrFail($request->event_id);
        $event->delete();
        return response()->json(['success' => true]);
    }

    // CRUD Pertanyaan Kuesioner per Event
    public function pertanyaanIndex($event_id)
    {
        $event = EventKuesioner::findOrFail($event_id);
        $pertanyaans = $event->pertanyaan()->orderBy('urutan')->get();
        return response()->json($pertanyaans);
    }

    public function pertanyaanStore(Request $request)
    {
        $request->validate([
            'event_kuesioner_id' => 'required|integer',
            'kategori' => 'required',
            'tipe' => 'required',
            'urutan' => 'required|integer',
            'pertanyaan' => 'required',
        ]);
        $data = $request->only(['event_kuesioner_id','kategori','tipe','urutan','pertanyaan']);
        // Handle skala
        if ($request->tipe === 'esai') {
            $data['skala'] = null;
        } else {
            $skala = $request->input('skala');
            if (is_array($skala)) {
                $data['skala'] = $skala;
            } elseif (is_string($skala)) {
                // Pisahkan dengan koma, trim spasi
                $data['skala'] = array_map('trim', explode(',', $skala));
            } else {
                $data['skala'] = [];
            }
        }
        $pertanyaan = PertanyaanKuesioner::create($data);
        return response()->json($pertanyaan, 201);
    }

    public function pertanyaanUpdate(Request $request)
    {
        $request->validate([
            'pertanyaan_id' => 'required|integer',
            'event_kuesioner_id' => 'required|integer',
            'kategori' => 'required',
            'tipe' => 'required',
            'urutan' => 'required|integer',
            'pertanyaan' => 'required',
        ]);
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $request->event_kuesioner_id)->findOrFail($request->pertanyaan_id);
        $data = $request->only(['kategori','tipe','urutan','pertanyaan']);
        // Handle skala
        if ($request->tipe === 'esai') {
            $data['skala'] = null;
        } else {
            $skala = $request->input('skala');
            if (is_array($skala)) {
                $data['skala'] = $skala;
            } elseif (is_string($skala)) {
                $data['skala'] = array_map('trim', explode(',', $skala));
            } else {
                $data['skala'] = [];
            }
        }
        $pertanyaan->update($data);
        return response()->json(['success' => true]);
    }

    public function pertanyaanDestroy(Request $request)
    {
        $request->validate([
            'pertanyaan_id' => 'required|integer',
            'event_kuesioner_id' => 'required|integer',
        ]);
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $request->event_kuesioner_id)->findOrFail($request->pertanyaan_id);
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
