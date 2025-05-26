<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MemberSettingController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin' || Auth::user()->status !== 'approved') {
            abort(403);
        }

        $query = User::with('profilAlumni')->where('role', 'alumni');

        // Ambil daftar jurusan unik dari tabel profil_alumni
        $jurusanList = ProfilAlumni::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($jurusan = $request->query('jurusan')) {
            $query->whereHas('profilAlumni', function ($q) use ($jurusan) {
                $q->where('jurusan', $jurusan);
            });
        }

        $alumni = $query->paginate(10)->appends($request->query());

        return view('pages.dashboard.member-setting', compact('alumni', 'jurusanList'));
    }

    public function show($id)
    {
        $alumni = User::with('profilAlumni')->where('role', 'alumni')->findOrFail($id);

        return response()->json($alumni);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:pending,approved,rejected',
            'nim' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:'.date('Y'),
            'tahun_lulus' => 'nullable|integer|min:1900|max:'.date('Y'),
            'no_telepon' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'nama' => $validated['nama'],
            'password' => bcrypt($validated['password']),
            'role' => 'alumni',
            'status' => $validated['status'],
        ]);

        $user->profilAlumni()->create($request->only([
            'nim', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
            'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
        ]));

        return response()->json($user->load('profilAlumni'), 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::with('profilAlumni')->findOrFail($id);

        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'nama' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:8',
            'status' => 'sometimes|required|in:pending,approved,rejected',
            'nim' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:'.date('Y'),
            'tahun_lulus' => 'nullable|integer|min:1900|max:'.date('Y'),
            'no_telepon' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string|max:255',
            'email_alternatif' => 'nullable|email|max:255',
        ]);

        $user->update($request->only(['email', 'nama', 'status']));
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->profilAlumni()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'nim', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'no_telepon',
                'alamat_rumah', 'ipk', 'linkedin', 'instagram', 'email_alternatif'
            ])
        );

        return response()->json([
            'success' => true,
            'data' => $user->load('profilAlumni')
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('role', 'alumni')->findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Alumni deleted successfully'
        ]);
    }

    public function exportAll()
    {
        $alumni = User::with('profilAlumni')
            ->where('role', 'alumni')
            ->get();

        $filename = 'all-alumni-' . now()->format('Ymd_His') . '.xlsx';

        // Use Laravel Excel for better Excel support
        return \Maatwebsite\Excel\Facades\Excel::download(new class($alumni) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle {
            private $alumni;
            public function __construct($alumni) { $this->alumni = $alumni; }
            public function array(): array {
                $data = [];
                foreach ($this->alumni as $alumni) {
                    $profil = $alumni->profilAlumni;
                    $data[] = [
                        'Nama' => $alumni->nama,
                        'Email' => $alumni->email,
                        'Status' => $alumni->status,
                        'NIM' => $profil->nim ?? '',
                        'Jurusan' => $profil->jurusan ?? '',
                        'Tahun Masuk' => $profil->tahun_masuk ?? '',
                        'Tahun Lulus' => $profil->tahun_lulus ?? '',
                        'No Telepon' => $profil->no_telepon ?? '',
                        'IPK' => $profil->ipk ?? '',
                        'Alamat Rumah' => $profil->alamat_rumah ?? '',
                        'LinkedIn' => $profil->linkedin ?? '',
                        'Instagram' => $profil->instagram ?? '',
                        'Email Alternatif' => $profil->email_alternatif ?? '',
                        'Created At' => $alumni->created_at,
                        'Updated At' => $alumni->updated_at,
                    ];
                }
                return $data;
            }
            public function headings(): array {
                return [
                    'Nama', 'Email', 'Status', 'NIM', 'Jurusan', 'Tahun Masuk', 'Tahun Lulus', 'No Telepon', 'IPK', 'Alamat Rumah', 'LinkedIn', 'Instagram', 'Email Alternatif', 'Created At', 'Updated At'
                ];
            }
            public function title(): string { return 'Alumni'; }
        }, $filename);
    }
}
