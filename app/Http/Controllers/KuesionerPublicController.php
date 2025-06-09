<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;
use Illuminate\Support\Facades\Auth;

class KuesionerPublicController extends Controller
{
    // List kuesioner aktif
    public function index()
    {
        $kuesioners = Kuesioner::where('status', 'aktif')->orderByDesc('created_at')->get();
        return view('pages.kuesioner.list', compact('kuesioners'));
    }

    // Form pengisian kuesioner
    public function form($id)
    {
        $kuesioner = Kuesioner::with('pertanyaan')->where('status', 'aktif')->findOrFail($id);
        return view('pages.kuesioner.form', compact('kuesioner'));
    }

    // Simpan jawaban kuesioner
    public function submit(Request $request, $id)
    {
        $kuesioner = Kuesioner::where('status', 'aktif')->findOrFail($id);
        $user = Auth::user();
        $jawaban = $request->except(['_token']);
        ResponKuesioner::create([
            'kuesioner_id' => $kuesioner->id,
            'user_id' => $user->id,
            'jawaban' => json_encode($jawaban),
        ]);
        return redirect()->route('kuesioner.list')->with('success', 'Terima kasih, jawaban Anda telah tersimpan.');
    }
} 