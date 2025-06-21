<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\EventPengembanganKarir;

class WorkshopAdminController extends Controller
{
    // Tampilkan halaman data workshop (admin)
    public function index()
    {
        $workshops = EventPengembanganKarir::orderByDesc('created_at')->get();
        return view('pages.dashboard.workshop', compact('workshops'));
    }

    // Handle form POST untuk CRUD (create/update/delete)
    public function store(Request $request)
    {
        try {
            $tipe = $request->input('tipe_event', 'event');
            $rules = EventPengembanganKarir::rules($tipe);
            $validated = $request->validate($rules);
            $data = $validated;
            $data['tipe_event'] = $tipe;
            // Pastikan harga_diskon tetap null jika tidak diisi
            if (!array_key_exists('harga_diskon', $data)) {
                $data['harga_diskon'] = null;
            }
            // Gabungkan tanggal_mulai + waktu_mulai dan tanggal_mulai + waktu_selesai jika ada
            if (!empty($data['waktu_mulai']) && !empty($data['tanggal_mulai'])) {
                $data['waktu_mulai'] = $data['tanggal_mulai'] . ' ' . $data['waktu_mulai'] . ':00';
            }
            if (!empty($data['waktu_selesai']) && !empty($data['tanggal_mulai'])) {
                $data['waktu_selesai'] = $data['tanggal_mulai'] . ' ' . $data['waktu_selesai'] . ':00';
            }
            // Handle upload foto ke storage/app/public/event-foto
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/event-foto', $fileName);
                $data['foto'] = str_replace('public/', '', $path); // simpan tanpa public/
            }
            EventPengembanganKarir::create($data);
            return redirect()->back()->with('success', 'Event berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan event: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $workshop = EventPengembanganKarir::findOrFail($id);
            $tipe = $request->input('tipe_event', $workshop->tipe_event ?? 'event');
            $rules = EventPengembanganKarir::rules($tipe);
            $validated = $request->validate($rules);
            $data = $validated;
            $data['tipe_event'] = $tipe;
            if (!array_key_exists('harga_diskon', $data)) {
                $data['harga_diskon'] = null;
            }
            if (!empty($data['waktu_mulai']) && !empty($data['tanggal_mulai'])) {
                $data['waktu_mulai'] = $data['tanggal_mulai'] . ' ' . $data['waktu_mulai'] . ':00';
            }
            if (!empty($data['waktu_selesai']) && !empty($data['tanggal_mulai'])) {
                $data['waktu_selesai'] = $data['tanggal_mulai'] . ' ' . $data['waktu_selesai'] . ':00';
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/event-foto', $fileName);
                $data['foto'] = str_replace('public/', '', $path);
            }
            $workshop->update($data);
            return redirect()->back()->with('success', 'Workshop berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate workshop: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $workshop = EventPengembanganKarir::findOrFail($id);
            $workshop->delete();
            return redirect()->back()->with('success', 'Workshop berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus workshop: ' . $e->getMessage());
        }
    }
}
