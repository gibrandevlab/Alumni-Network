<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminSettingController extends Controller
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

        $query = User::with('profilAdmin')->where('role', 'admin');

        // Ambil daftar jabatan unik dari tabel profil_admin
        $jabatanList = ProfilAdmin::select('jabatan')->distinct()->pluck('jabatan')->filter()->values();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($jabatan = $request->query('jabatan')) {
            $query->whereHas('profilAdmin', function ($q) use ($jabatan) {
                $q->where('jabatan', $jabatan);
            });
        }

        $admins = $query->paginate(10)->appends($request->query());

        return view('pages.dashboard.AdminSetting', compact('admins', 'jabatanList'));
    }

    public function show($id)
    {
        $admin = User::with('profilAdmin')->where('role', 'admin')->findOrFail($id);
        return response()->json($admin);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:pending,approved,rejected',
            'no_telepon' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'nama' => $validated['nama'],
            'password' => bcrypt($validated['password']),
            'role' => 'admin',
            'status' => $validated['status'],
        ]);

        $user->profilAdmin()->create($request->only(['no_telepon', 'jabatan']));

        return response()->json($user->load('profilAdmin'), 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::with('profilAdmin')->findOrFail($id);

        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'nama' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:8',
            'status' => 'sometimes|required|in:pending,approved,rejected',
            'no_telepon' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['email', 'nama', 'status']));
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->profilAdmin()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['no_telepon', 'jabatan'])
        );

        return response()->json([
            'success' => true,
            'data' => $user->load('profilAdmin')
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully'
        ]);
    }

    public function exportAll()
    {
        $admins = User::with('profilAdmin')
            ->where('role', 'admin')
            ->get();

        $filename = 'all-admins-' . now()->format('Ymd_His') . '.xlsx';

        // Use Laravel Excel for better Excel support
        return \Maatwebsite\Excel\Facades\Excel::download(new class($admins) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle {
            private $admins;
            public function __construct($admins) { $this->admins = $admins; }
            public function array(): array {
                $data = [];
                foreach ($this->admins as $admin) {
                    $profil = $admin->profilAdmin;
                    $data[] = [
                        'Nama' => $admin->nama,
                        'Email' => $admin->email,
                        'Status' => $admin->status,
                        'No Telepon' => $profil->no_telepon ?? '',
                        'Jabatan' => $profil->jabatan ?? '',
                        'Created At' => $admin->created_at,
                        'Updated At' => $admin->updated_at,
                    ];
                }
                return $data;
            }
            public function headings(): array {
                return [
                    'Nama', 'Email', 'Status', 'No Telepon', 'Jabatan', 'Created At', 'Updated At'
                ];
            }
            public function title(): string { return 'Admin'; }
        }, $filename);
    }
}
