<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventKuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;
use App\Exports\ResponKuesionerExport;
use Maatwebsite\Excel\Facades\Excel;

class KuesionerEventController extends Controller
{
    // Tampilkan 1 blade view utama (dashboard kuesioner)
    public function index()
    {
        $events = EventKuesioner::withCount('pertanyaan', 'respon')->get();
        return view('pages.dashboard.kuesioner', compact('events'));
    }

    // CRUD Event Kuesioner
    public function store(Request $request)
    {
        $event = EventKuesioner::create($request->all());
        return response()->json(['success' => true, 'event' => $event]);
    }
    public function update(Request $request, EventKuesioner $event)
    {
        $event->update($request->all());
        return response()->json(['success' => true, 'event' => $event]);
    }
    public function destroy(EventKuesioner $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }

    // CRUD Pertanyaan per Event
    public function pertanyaanIndex(EventKuesioner $event)
    {
        $pertanyaan = $event->pertanyaan()->orderBy('urutan')->get();
        return response()->json($pertanyaan);
    }
    public function pertanyaanStore(Request $request, EventKuesioner $event)
    {
        $pertanyaan = $event->pertanyaan()->create($request->all());
        return response()->json(['success' => true, 'pertanyaan' => $pertanyaan]);
    }
    public function pertanyaanUpdate(Request $request, EventKuesioner $event, PertanyaanKuesioner $pertanyaan)
    {
        $pertanyaan->update($request->all());
        return response()->json(['success' => true, 'pertanyaan' => $pertanyaan]);
    }
    public function pertanyaanDestroy(EventKuesioner $event, PertanyaanKuesioner $pertanyaan)
    {
        $pertanyaan->delete();
        return response()->json(['success' => true]);
    }

    // Download Excel respon kuesioner (jawaban json)
    public function downloadRespon(EventKuesioner $event)
    {
        $filename = 'respon_kuesioner_event_' . $event->id . '.xlsx';
        return Excel::download(new ResponKuesionerExport($event->id), $filename);
    }

    // Get single event as JSON (for AJAX edit modal)
    public function getEventJson(EventKuesioner $event)
    {
        return response()->json(['success' => true, 'event' => $event]);
    }

    // Get single pertanyaan as JSON (for AJAX edit modal)
    public function getPertanyaanJson(EventKuesioner $event, PertanyaanKuesioner $pertanyaan)
    {
        return response()->json(['success' => true, 'pertanyaan' => $pertanyaan]);
    }
}
