<div id="chartContainer" class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-100 bg-opacity-40 backdrop-blur-lg rounded-lg shadow-lg shadow-tl shadow-br border-4">
    <div class="rounded-t mb-0 px-0 border-0">
        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h3 class="font-semibold text-base text-black">Status Karir Alumni (5 Tahun Terakhir)</h3>
            </div>
            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                <div class="flex items-center space-x-4">
                    <select name="jurusan1" class="bg-gray-700 text-white rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="" {{ request('jurusan1') == '' ? 'selected' : '' }}>Semua Jurusan</option>
                        @foreach([
                            'Ilmu Komunikasi (S1)', 'Sastra Inggris (S1)', 'Public Relations (D3)',
                            'Broadcasting (D3)', 'Advertising (D3)', 'Bahasa Inggris (D3)',
                            'Sistem Informasi (S1)', 'Teknologi Informasi (S1)', 'Software Engineering (S1)',
                            'Informatika (S1)', 'Teknik Industri (S1)', 'Teknik Elektro (S1)',
                            'Sistem Informasi (D3)', 'Sistem Informasi Akuntansi (D3)', 'Teknologi Komputer (D3)',
                            'Manajemen (S1)', 'Akuntansi (S1)', 'Pariwisata (S1)', 'Hukum Bisnis (S1)',
                            'Administrasi Perkantoran (D3)', 'Akuntansi (D3)', 'Administrasi Bisnis (D3)',
                            'Manajemen Pajak (D3)', 'Perhotelan (D3)', 'Hukum Bisnis (S1)', 'Ilmu Hukum (S1)',
                            'Hukum Internasional (S1)', 'Ilmu Keperawatan (S1)', 'Psikologi (S1)',
                            'Ilmu Keperawatan (D3)', 'Profesi NERS'
                        ] as $option)
                            <option value="{{ $option }}" {{ request('jurusan1') == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white font-semibold rounded-md px-6 py-2 hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="block w-full overflow-x-auto px-4">
            <div id="statuskarir" class="w-full font-sans" style="background-color: #2d3748; color: #fff;" id="status-tahun-chart"></div>
        </div>
    </div>
</div>

<script>
    // Dummy data per jurusan dan tahun
    var dummyPerJurusan = {
        'Sistem Informasi (S1)': {
            '2025': { status_1: 10, status_2: 5, status_3: 2 },
            '2024': { status_1: 8, status_2: 4, status_3: 1 },
            '2023': { status_1: 7, status_2: 3, status_3: 2 },
            '2022': { status_1: 6, status_2: 2, status_3: 1 },
            '2021': { status_1: 5, status_2: 1, status_3: 0 }
        },
        'Teknologi Informasi (S1)': {
            '2025': { status_1: 12, status_2: 6, status_3: 3 },
            '2024': { status_1: 9, status_2: 5, status_3: 2 },
            '2023': { status_1: 8, status_2: 4, status_3: 1 },
            '2022': { status_1: 7, status_2: 3, status_3: 2 },
            '2021': { status_1: 6, status_2: 2, status_3: 1 }
        },
        'Ilmu Komunikasi (S1)': {
            '2025': { status_1: 5, status_2: 7, status_3: 2 },
            '2024': { status_1: 4, status_2: 6, status_3: 1 },
            '2023': { status_1: 3, status_2: 5, status_3: 2 },
            '2022': { status_1: 2, status_2: 4, status_3: 1 },
            '2021': { status_1: 1, status_2: 3, status_3: 0 }
        },
        // Tambahkan jurusan lain jika perlu
    };
    var jurusanSelected = "{{ request('jurusan1') }}";
    if (!jurusanSelected || !dummyPerJurusan[jurusanSelected]) {
        jurusanSelected = 'Sistem Informasi (S1)'; // default
    }
    var dataAlumni = dummyPerJurusan[jurusanSelected];
    var currentYear = new Date().getFullYear();
    var years = [];
    for (var y = currentYear; y > currentYear - 5; y--) {
        years.push(y.toString());
    }
    var bekerjaData = 0;
    var melanjutkanPendidikanData = 0;
    var tidakBekerjaData = 0;
    years.forEach(function(year) {
        var yearData = dataAlumni[year] || { status_1: 0, status_2: 0, status_3: 0 };
        bekerjaData += yearData.status_1;
        melanjutkanPendidikanData += yearData.status_2;
        tidakBekerjaData += yearData.status_3;
    });
    var options = {
        series: [bekerjaData, melanjutkanPendidikanData, tidakBekerjaData],
        chart: {
            type: 'pie',
            height: 350,
            background: '#e5e5e5',
        },
        title: {
            text: 'Alumni Career Status (Last 5 Years)',
            align: 'center',
            style: {
                fontSize: '18px',
                color: '#333'
            }
        },
        labels: ['Bekerja', 'Pendidikan', 'Tidak Bekerja'],
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '12px',
                colors: ['#000']
            },
            dropShadow: {
                enabled: false,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            theme: 'light',
            style: {
                fontSize: '14px',
                color: '#000'
            }
        },
        legend: {
            show: true,
            position: 'right',
            verticalAlign: 'middle',
            horizontalAlign: 'center',
            fontSize: '12px',
            fontWeight: 400,
            labels: {
                colors: ['#000'],
            }
        },
        colors: ['#9694FF', '#78B3CE', '#AA5486'],
        stroke: {
            width: 2,
            colors: ['#fff']
        },
    };
    var chart = new ApexCharts(document.querySelector("#statuskarir"), options);
    chart.render();
</script>
