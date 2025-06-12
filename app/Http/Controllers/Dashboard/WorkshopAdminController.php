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
            $rules = [
                'judul_event' => 'required|string|max:255',
                'dilaksanakan_oleh' => 'required|string|max:100',
                'foto' => 'nullable|image|max:2048',
                'link' => 'nullable|string',
                'status' => 'required|in:aktif,nonaktif',
            ];
            if ($tipe === 'event') {
                $rules = array_merge($rules, [
                    'deskripsi_event' => 'required|string',
                    'tanggal_mulai' => 'required|date',
                    'tanggal_akhir_pendaftaran' => 'required|date|after_or_equal:tanggal_mulai',
                    'harga_daftar' => 'nullable|integer',
                    'maksimal_peserta' => 'nullable|integer',
                ]);
            } else {
                $rules['deskripsi_event'] = 'nullable|string';
                $rules['tanggal_mulai'] = 'nullable|date';
                $rules['tanggal_akhir_pendaftaran'] = 'nullable|date';
                $rules['harga_daftar'] = 'nullable|integer';
                $rules['maksimal_peserta'] = 'nullable|integer';
            }
            $validated = $request->validate($rules);
            $data = $validated;
            $data['tipe_event'] = $tipe;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/events'), $fileName);
                $data['foto'] = 'images/events/' . $fileName;
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
            $validated = $request->validate([
                'judul_event' => 'required|string|max:255',
                'deskripsi_event' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir_pendaftaran' => 'required|date|after_or_equal:tanggal_mulai',
                'dilaksanakan_oleh' => 'required|string|max:100',
                'foto' => 'nullable|image|max:2048',
                'link' => 'nullable|string',
                'harga_daftar' => 'nullable|integer',
                'maksimal_peserta' => 'nullable|integer',
            ]);
            $workshop = EventPengembanganKarir::findOrFail($id);
            $data = $validated;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/events'), $fileName);
                $data['foto'] = 'images/events/' . $fileName;
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
