<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
                    new class implements FromCollection, WithTitle, WithHeadings, WithStyles {
                        public function collection()
                        {
                            return ResponKuesioner::get(['event_kuesioner_id', 'user_id', 'jawaban'])->map(function($item) {
                                $jawaban = json_decode($item->jawaban, true);
                                foreach ($jawaban as $key => $value) {
                                    $item->{"jawaban_$key"} = $value;
                                }
                                unset($item->jawaban);
                                return $item;
                            });
                        }

                        public function title(): string
                        {
                            return 'Respon Kuesioner';
                        }

                        public function headings(): array
                        {
                            // Header Utama
                            $headers = ['Event Kuesioner ID', 'User ID'];

                            // Tambahkan header untuk kolom jawaban yang ter-decode
                            $firstItem = ResponKuesioner::first();
                            if ($firstItem) {
                                $jawaban = json_decode($firstItem->jawaban, true);
                                foreach ($jawaban as $key => $value) {
                                    $headers[] = "Jawaban $key";
                                }
                            }

                            return $headers;
                        }

                        public function styles(Worksheet $sheet)
                        {
                            // Merge header untuk kolom jawaban (dari C3 dan seterusnya)
                            $firstItem = ResponKuesioner::first();
                            if ($firstItem) {
                                $jawaban = json_decode($firstItem->jawaban, true);
                                $startCol = 3; // Kolom pertama jawaban dimulai dari kolom C

                                $sheet->mergeCells("C1:" . $sheet->getHighestColumn() . "1");

                                $sheet->getStyle("A1:" . $sheet->getHighestColumn() . "1")->applyFromArray([
                                    'alignment' => [
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                    ],
                                    'font' => [
                                        'bold' => true,
                                    ],
                                ]);
                            }
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
