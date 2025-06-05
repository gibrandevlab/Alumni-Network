<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventKuesioner;
use App\Models\PertanyaanKuesioner;

class KuesionerPertanyaanController extends Controller
{
    // Tampilkan halaman tab kategori untuk satu event
    public function index($eventId)
    {
        $event = EventKuesioner::findOrFail($eventId);
        $pertanyaans = $event->pertanyaan()->orderBy('kategori')->orderBy('urutan')->get();
        // Kelompokkan per kategori
        $kategori = $pertanyaans->groupBy('kategori');
        return view('pertanyaan.index', compact('event', 'kategori'));
    }

    // Store pertanyaan baru
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'kategori' => 'required',
            'tipe' => 'required',
            'urutan' => 'required|integer',
            'pertanyaan' => 'required',
        ]);
        $data = $request->only(['kategori','tipe','urutan','pertanyaan']);
        $data['event_kuesioner_id'] = $eventId;
        $data['skala'] = $request->input('skala', []);
        // Pastikan urutan unik di kategori
        $exists = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
            ->where('kategori', $data['kategori'])
            ->where('urutan', $data['urutan'])
            ->exists();
        if ($exists) {
            return back()->with('error', 'Urutan sudah digunakan di kategori ini.');
        }
        PertanyaanKuesioner::create($data);
        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    // Edit pertanyaan (form)
    public function edit($eventId, $id)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)->findOrFail($id);
        return response()->json($pertanyaan);
    }

    // Update pertanyaan
    public function update(Request $request, $eventId, $id)
    {
        $request->validate([
            'tipe' => 'required',
            'urutan' => 'required|integer',
            'pertanyaan' => 'required',
        ]);
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)->findOrFail($id);
        $data = $request->only(['tipe','urutan','pertanyaan']);
        $data['skala'] = $request->input('skala', []);
        // Pastikan urutan unik di kategori
        $exists = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
            ->where('kategori', $pertanyaan->kategori)
            ->where('urutan', $data['urutan'])
            ->where('id', '!=', $id)
            ->exists();
        if ($exists) {
            return back()->with('error', 'Urutan sudah digunakan di kategori ini.');
        }
        $pertanyaan->update($data);
        return back()->with('success', 'Pertanyaan berhasil diupdate.');
    }

    // Hapus pertanyaan
    public function destroy($eventId, $id)
    {
        $pertanyaan = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)->findOrFail($id);
        $kategori = $pertanyaan->kategori;
        $pertanyaan->delete();
        // Rebalance urutan di kategori
        $pertanyaans = PertanyaanKuesioner::where('event_kuesioner_id', $eventId)
            ->where('kategori', $kategori)
            ->orderBy('urutan')->get();
        $i = 1;
        foreach ($pertanyaans as $p) {
            $p->urutan = $i++;
            $p->save();
        }
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
