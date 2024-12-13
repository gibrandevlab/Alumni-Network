<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventPengembanganKarir;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PendaftaranEvent;


class EventController extends Controller
{
    public function index()
    {
        // Menggunakan pagination, ganti all() menjadi paginate()
        $event = EventPengembanganKarir::paginate(10);  // Membatasi jumlah event per halaman
        $profil = $this->getProfile(Auth::id(), Auth::user()->role);
        $peranPengguna = Auth::user()->role;

        // Hanya Admin yang dapat mengakses data Alumni
        if ($peranPengguna === 'admin') {
            $users = User::where('role', 'alumni')
                ->whereDoesntHave('profilAlumni')  // Menggunakan relasi Eloquent untuk menghindari query yang berlebihan
                ->orderByDesc('updated_at')
                ->get();
        } else {
            $users = collect();  // Kosongkan jika bukan admin
        }

        return view('pages.dashboard.event', compact('event', 'profil', 'peranPengguna', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh' => 'required|string|max:255',
            'tipe_event' => 'required|string',
            'foto' => 'required|image|max:2048',
            'link' => 'required|string',
        ]);

        // Simpan Foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('images/events', $file, $fileName);
            $validatedData['foto'] = 'images/events/' . $fileName;
        }

        // Generate QR Code untuk Link
        $validatedData['link'] = $this->generateQrCode($validatedData['link']);

        // Simpan ke Database
        EventPengembanganKarir::create($validatedData);

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function update(Request $request, EventPengembanganKarir $event)
    {
        $validatedData = $request->validate([
            'judul_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh' => 'required|string|max:255',
            'tipe_event' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'link' => 'required|string',
        ]);

        // Update Foto jika diunggah ulang
        if ($request->hasFile('foto')) {
            $this->deleteFile($event->foto);  // Hapus foto lama
            $mediaPath = $request->file('foto')->store('images/events', 'public');
            $validatedData['foto'] = $mediaPath;
        }

        // Generate QR Code baru untuk Link
        $this->deleteFile($event->link);  // Hapus QR Code lama
        $validatedData['link'] = $this->generateQrCode($validatedData['link']);

        // Update ke Database
        $event->update($validatedData);

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = EventPengembanganKarir::findOrFail($id);

        // Hapus Foto
        $this->deleteFile($event->foto);  // Menghapus foto

        // Hapus QR Code
        $qrCodePath = 'images/events/qr/' . $event->link . '.png';  // Path QR Code di storage

        // Jika ada event lain yang memakai QR Code yang sama, maka jangan hapus QR Code
        if (!EventPengembanganKarir::where('link', $event->link)->where('id', '!=', $id)->exists()) {
            $this->deleteFile($qrCodePath);  // Menghapus QR Code
        }

        // Hapus event dari database
        $event->delete();

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil dihapus.');
    }

    private function deleteFile($path)
    {
        // Pastikan file ada di storage publik sebelum mencoba menghapusnya
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }



    // Fungsi untuk mendapatkan profil pengguna
    private function getProfile($userId, $userRole)
    {
        // Hanya mengizinkan admin untuk mengambil data profil Alumni
        if ($userRole === 'admin') {
            $profileClass = ProfilAdmin::class;
        } else {
            $profileClass = ProfilAlumni::class;
        }

        return $profileClass::select($this->getProfileColumns($userRole))
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    // Menentukan kolom yang perlu diambil berdasarkan peran pengguna
    private function getProfileColumns($role)
    {
        return [
            'admin' => ['nama', 'email', 'no_telepon', 'jabatan'],
            'alumni' => ['nama', 'tahun_lulus', 'linkedin', 'instagram', 'email', 'no_telepon'],
        ][$role] ?? [];
    }


    // Fungsi untuk generate QR Code
    private function generateQrCode($link)
    {
        // Buat slug dari link untuk dijadikan nama file
        $slug = parse_url($link, PHP_URL_HOST) . parse_url($link, PHP_URL_PATH);

        $fileName = $slug; // Nama file tanpa ekstensi
        $qrCodePath = 'images/events/qr/' . $fileName . '.png'; // Tambahkan ekstensi hanya untuk penyimpanan

        // Generate QR code
        $qrCodeContent = QrCode::format('png')
            ->size(300) // Ukuran QR
            ->margin(1) // Margin
            ->eye('circle') // Gaya corner
            ->style('dot') // Gaya dot
            ->generate($link);

        // Simpan QR code di storage publik
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

        return $fileName; // Kembalikan nama file tanpa ekstensi
    }

    public function mendaftar(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login untuk mendaftar event.');
        }

        $eventId = $request->query('event');

        $event = EventPengembanganKarir::find($eventId);

        if (!$event) {
            return redirect()->back()->with('error', 'Event tidak ditemukan.');
        }

        $userId = Auth::id();

        $existingRegistration = PendaftaranEvent::where('event_id', $event->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar untuk event ini.');
        }

        PendaftaranEvent::create([
            'event_id' => $event->id,
            'user_id' => $userId,
            'status_pendaftaran' => 'dalam_proses',
        ]);

        return redirect('/#event')->with('success', 'Pendaftaran berhasil. Status Anda sedang dalam proses.');


    }
}
