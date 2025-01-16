<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

// Import Model
use App\Models\EventPengembanganKarir;
use App\Models\PendaftaranEvent;
use App\Models\ProfilAdmin;
use App\Models\ProfilAlumni;
use App\Models\ResponKuesioner;
use App\Models\User;

class ExportDataController extends Controller
{
    /**
     * Menampilkan halaman ekspor data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.dashboard.ExportData');
    }

    /**
     * Ekspor semua data ke file Excel dengan beberapa sheet.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new class implements WithMultipleSheets {
            public function sheets(): array
            {
                return [
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return EventPengembanganKarir::all();
                        }

                        public function title(): string
                        {
                            return 'Workshop Karir';
                        }
                    },
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return PendaftaranEvent::all();
                        }

                        public function title(): string
                        {
                            return 'Pendaftaran Event';
                        }
                    },
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return ProfilAdmin::all();
                        }

                        public function title(): string
                        {
                            return 'Profil Admin';
                        }
                    },
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return ProfilAlumni::all();
                        }

                        public function title(): string
                        {
                            return 'Profil Alumni';
                        }
                    },
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return ResponKuesioner::all();
                        }

                        public function title(): string
                        {
                            return 'Respon Kuesioner';
                        }
                    },
                    new class implements FromCollection, WithTitle {
                        public function collection()
                        {
                            return User::all();
                        }

                        public function title(): string
                        {
                            return 'Pengguna';
                        }
                    },
                ];
            }
        }, 'all-data.xlsx');
    }
}
