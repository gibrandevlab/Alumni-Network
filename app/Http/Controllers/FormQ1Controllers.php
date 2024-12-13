<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ResponKuesioner;
use App\Models\ProfilAlumni;

class FormQ1Controllers extends Controller
{
    public function index()
    {
        $this->authorizeUser();
        return view('pages.Kuesioner.Q1', ['userId' => Auth::id()]);
    }

    public function index_Public()
    {
        return view('pages.Kuesioner.Q1_2015-2020');
    }

    public function searchByNim($nim)
    {
        $alumni = ProfilAlumni::where('nim', $nim)
            ->whereBetween('tahun_lulus', [2015, 2020])
            ->first(['id', 'nim', 'nama', 'tahun_lulus', 'jurusan']);

        if (!$alumni) {
            return response()->json(['message' => 'Alumni not found.'], 404);
        }

        return response()->json($alumni);
    }

    public function store_public(Request $request)
    {
        if (Auth::check()) {
            $profilAlumni = ProfilAlumni::where('user_id', Auth::id())->firstOrFail();
        } else {
            $validatedData = $request->validate([
                'nim' => 'required|string|max:20',
                'tahun_lulus' => 'required|integer|between:2015,2020',
            ]);

            $profilAlumni = ProfilAlumni::where('nim', $validatedData['nim'])->firstOrFail();
        }

        $jawaban = $request->except(['nim', 'nama', 'jurusan', 'tahun_lulus', '_token']);

        $responKuesioner = ResponKuesioner::updateOrCreate(
            [
                'event_kuesioner_id' => 1,
                'user_id' => $profilAlumni->user_id,
            ],
            ['jawaban' => json_encode($jawaban)]
        );

        $message = $responKuesioner->wasRecentlyCreated
            ? 'Respon kuesioner berhasil disimpan.'
            : 'Respon kuesioner berhasil diperbarui.';

        return response()->json([
            'message' => $message,
            'data' => $jawaban,
            'respon_kuesioner' => $responKuesioner,
        ]);
    }

    private function authorizeUser()
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->send();
        }

        $user = Auth::user();
        if ($user->role !== 'alumni' || $user->status !== 'approved') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.')->send();
        }
    }

}
