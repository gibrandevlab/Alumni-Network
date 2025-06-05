<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventKuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;
use App\Models\User;
use App\Exports\ResponKuesionerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class KuesionerEventController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $events = EventKuesioner::withCount('respon')->orderBy('created_at', 'desc')->get();
            return response()->json(['data' => $events]);
        }

        return view('pages.dashboard.kuesioner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_event'     => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'target_peserta'  => 'required|in:alumni,mahasiswa,umum',
            'tahun_lulusan'   => 'nullable|integer',
            'status'          => 'required|in:draft,active,completed',
        ]);

        $data = $request->only([
            'judul_event', 'deskripsi_event',
            'tanggal_mulai', 'tanggal_selesai',
            'target_peserta', 'tahun_lulusan', 'status'
        ]);

        $data['created_by'] = Auth::id();
        $event = EventKuesioner::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Event kuesioner berhasil dibuat.'
        ]);
    }

    public function update(Request $request, $eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);

        $request->validate([
            'judul_event'     => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'target_peserta'  => 'required|in:alumni,mahasiswa,umum',
            'tahun_lulusan'   => 'nullable|integer',
            'status'          => 'required|in:draft,active,completed',
        ]);

        $event->update($request->only([
            'judul_event', 'deskripsi_event',
            'tanggal_mulai', 'tanggal_selesai',
            'target_peserta', 'tahun_lulusan', 'status'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Event kuesioner berhasil diperbarui.'
        ]);
    }

    public function destroy($eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $event->pertanyaan()->delete();
        ResponKuesioner::where('event_kuesioner_id', $eventId)->delete();
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event kuesioner berhasil dihapus.'
        ]);
    }

    public function pertanyaanStore(Request $request, $eventId)
    {
        $request->validate([
            'kategori'   => 'required|string',
            'tipe'       => 'required|in:esai,pilihan_ganda,skala',
            'urutan'     => 'nullable|integer',
            'pertanyaan' => 'required|string',
            'skala'      => 'nullable|array',
        ]);

        $data = $request->only(['kategori', 'tipe', 'urutan', 'pertanyaan', 'skala']);
        $data['event_kuesioner_id'] = $eventId;

        PertanyaanKuesioner::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil ditambahkan.'
        ], 201);
    }

    public function pertanyaanUpdate(Request $request, $eventId, $pertanyaanId)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                          ->where('id', $pertanyaanId)
                                          ->firstOrFail();

        $request->validate([
            'kategori'   => 'required|string',
            'tipe'       => 'required|in:esai,pilihan_ganda,skala',
            'urutan'     => 'nullable|integer',
            'pertanyaan' => 'required|string',
            'skala'      => 'nullable|array',
        ]);

        $pertanyaan->update($request->only(['kategori', 'tipe', 'urutan', 'pertanyaan', 'skala']));

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil diperbarui.'
        ], 200);
    }

    public function pertanyaanDestroy($eventId, $pertanyaanId)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                          ->where('id', $pertanyaanId)
                                          ->firstOrFail();
        $pertanyaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus.'
        ], 200);
    }

    public function pertanyaanList($eventId)
    {
        $pertanyaans = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                          ->orderBy('urutan', 'asc')
                                          ->get();

        return response()->json([
            'data' => $pertanyaans
        ]);
    }

    public function downloadRespon($eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $responList = ResponKuesioner::where('event_kuesioner_id', $eventId)
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        $header = ['Nama Pengisi', 'Email', 'Waktu Isi'];
        $allPertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                            ->orderBy('urutan')
                                            ->pluck('pertanyaan')
                                            ->toArray();
        $header = array_merge($header, $allPertanyaan);

        $rows = [];
        foreach ($responList as $r) {
            $row = [];
            $row[] = $r->user ? $r->user->name : '-';
            $row[] = $r->user ? $r->user->email : $r->guest_email;
            $row[] = Carbon::parse($r->created_at)->format('Y-m-d H:i:s');

            $jawabanSet = json_decode($r->jawaban, true);
            foreach ($allPertanyaan as $idx => $pert) {
                $jawab = $jawabanSet[$idx] ?? '-';
                $row[] = $jawab;
            }

            $rows[] = $row;
        }

        $filename = 'respon_kuesioner_event_' . $eventId . '.xlsx';
        return Excel::download(new ResponKuesionerExport([$header, ...$rows]), $filename);
    }

    public function responCreate($eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                          ->orderBy('urutan')
                                          ->get();

        return view('dashboard.kuesioner.respon_create', [
            'event'      => $event,
            'pertanyaan' => $pertanyaan
        ]);
    }

    public function responStore(Request $request, $eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
                                          ->orderBy('urutan')
                                          ->get();

        $rules = [];
        foreach ($pertanyaan as $p) {
            $rules["jawaban.{$p->id}"] = 'required';
        }

        if (!Auth::check()) {
            $rules['guest_email'] = 'required|email';
        }

        $request->validate($rules);

        $respon = new ResponKuesioner();
        $respon->event_kuesioner_id = $eventId;
        $respon->user_id = Auth::check() ? Auth::id() : null;
        $respon->guest_email = Auth::check() ? null : $request->input('guest_email');

        $jawabanData = [];
        foreach ($pertanyaan as $p) {
            $jawabanData[$p->id] = $request->input("jawaban.{$p->id}");
        }

        $respon->jawaban = json_encode($jawabanData);
        $respon->save();

        return response()->json([
            'success' => true,
            'message' => 'Respon kuesioner berhasil tersimpan.',
            'respon_id' => $respon->id
        ]);
    }

    public function responShow($eventId, $responId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $respon = ResponKuesioner::where('event_kuesioner_id', $eventId)
                                 ->where('id', $responId)
                                 ->firstOrFail();

        return view('dashboard.kuesioner.respon_show', [
            'event'  => $event,
            'respon' => $respon
        ]);
    }

    public function responDetail($eventId, $responId)
    {
        $respon = ResponKuesioner::where('event_kuesioner_id', $eventId)
                                 ->where('id', $responId)
                                 ->firstOrFail();

        $jawabanData = json_decode($respon->jawaban, true);
        $detail = [];
        foreach ($jawabanData as $pertanyaanId => $jawab) {
            $pert = PertanyaanKuesioner::find($pertanyaanId);
            if ($pert) {
                $detail[] = [
                    'pertanyaan' => $pert->pertanyaan,
                    'jawaban'    => $jawab
                ];
            }
        }

        return response()->json([
            'data' => $detail
        ]);
    }
}
