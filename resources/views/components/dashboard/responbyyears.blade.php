<div id="chartContainer" class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-100 bg-opacity-40 backdrop-blur-lg rounded-lg shadow-lg shadow-tl shadow-br border-4">
    <div class="rounded-t mb-0 px-0 border-0">
        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h3 class="font-semibold text-base text-white">Status Karir Alumni</h3>
            </div>
            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                <div class="flex items-center space-x-4">
                    <select name="jurusandefault" class="bg-gray-700 text-white rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="" {{ request('jurusandefault') == '' ? 'selected' : '' }}>Semua Jurusan</option>
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
                            <option value="{{ $option }}" {{ request('jurusandefault') == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white font-semibold rounded-md px-6 py-2 hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="block w-full overflow-x-auto px-4">
            <!-- Pastikan id container sesuai -->
            <div id="barchart1" class="w-full font-sans" id="responbyyears-barchart"></div>
        </div>
    </div>
</div>

<script>
    var dataPartisipasi = @json($persentasePerTahun);
    dataPartisipasi = dataPartisipasi.filter(item => item.tahun_lulus !== null);

    var tahun = dataPartisipasi.map(item => item.tahun_lulus);
    var persentase = dataPartisipasi.map(item => item.persentase);

    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Partisipasi Alumni (%)',
                data: persentase
            }],
            chart: {
                type: 'bar',
                height: 350,
                background: '#e5e5e5',
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    // Dua angka di belakang koma
                    return parseFloat(val).toFixed(2) + "%";
                },
                style: {
                    fontSize: '10px',
                    colors: ['#333']
                }
            },
            xaxis: {
                categories: tahun,
                title: {
                    text: 'Tahun Kelulusan',
                    style: { color: '#333' }
                },
                labels: { style: { color: '#333' } }
            },
            yaxis: {
                title: {
                    text: 'Persentase Partisipasi (%)',
                    style: { color: '#333' }
                },
                labels: {
                    style: { color: '#333' },
                    formatter: function (val) {
                        return parseFloat(val).toFixed(2) + "%";
                    }
                }
            },
            title: {
                text: 'Response Rate By Graduate Year',
                align: 'center',
                style: { fontSize: '18px', color: '#333' }
            },
            colors: ['#1E90FF80'],
            stroke: {
                colors: ['#1E90FF'],
                width: 2,
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 3200 },
                    legend: { position: 'bottom' }
                }
            }]
        };

        // Perhatikan penggunaan id "barchart1" sesuai dengan HTML
        var chart = new ApexCharts(document.querySelector("#barchart1"), options);
        chart.render();

        // Jika ada elemen dataColumns, tampilkan data tambahan dengan dua angka desimal
        var dataColumns = document.getElementById('dataColumns');
        if(dataColumns){
            dataPartisipasi.forEach(function(item) {
                dataColumns.innerHTML += `<div class="flex justify-between py-2">
                                                <div>${item.tahun_lulus}</div>
                                                <div>${item.persentase.toFixed(2)}%</div>
                                            </div>`;
            });
        }

        const chartContainer = document.getElementById('chartContainer');
        const textColor = window.getComputedStyle(chartContainer).backgroundColor === 'rgb(225, 225, 225)' ? 'text-black' : 'text-white';
        chartContainer.querySelectorAll('h3, button, .flex > div').forEach(el => {
            el.classList.add(textColor);
        });

        var downloadButtons = document.querySelectorAll('.apexcharts-menu-item');
        downloadButtons.forEach(function(button) {
            button.style.color = 'black';
        });
    });
</script>
