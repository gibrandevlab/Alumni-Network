<div id="chartContainer"
    class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-100 bg-opacity-40 backdrop-blur-lg rounded-lg shadow-lg shadow-tl shadow-br border-4">
    <div class="rounded-t mb-0 px-0 border-0">
        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h3 class="font-semibold text-base text-white">Status Karir Alumni</h3>
            </div>
            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                <div class="flex items-center space-x-4">
                    <select name="jurusan2"
                        class="bg-gray-700 text-white rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="" {{ request('jurusan2') == '' ? 'selected' : '' }}>Semua Jurusan</option>
                        @foreach (['Ilmu Komunikasi (S1)', 'Sastra Inggris (S1)', 'Public Relations (D3)', 'Broadcasting (D3)', 'Advertising (D3)', 'Bahasa Inggris (D3)', 'Sistem Informasi (S1)', 'Teknologi Informasi (S1)', 'Software Engineering (S1)', 'Informatika (S1)', 'Teknik Industri (S1)', 'Teknik Elektro (S1)', 'Sistem Informasi (D3)', 'Sistem Informasi Akuntansi (D3)', 'Teknologi Komputer (D3)', 'Manajemen (S1)', 'Akuntansi (S1)', 'Pariwisata (S1)', 'Hukum Bisnis (S1)', 'Administrasi Perkantoran (D3)', 'Akuntansi (D3)', 'Administrasi Bisnis (D3)', 'Manajemen Pajak (D3)', 'Perhotelan (D3)', 'Hukum Bisnis (S1)', 'Ilmu Hukum (S1)', 'Hukum Internasional (S1)', 'Ilmu Keperawatan (S1)', 'Psikologi (S1)', 'Ilmu Keperawatan (D3)', 'Profesi NERS'] as $option)
                            <option value="{{ $option }}" {{ request('jurusan2') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold rounded-md px-6 py-2 hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="block w-full overflow-x-auto px-4">
            <div id="statuskarir2" class="w-full font-sans"></div>
        </div>
    </div>
</div>

<script>
    var dataAlumni = @json($jawabanKuesioner2);

    var jurusanFilter = '{{ request('jurusan') }}';
    var filteredData = [];

    if (jurusanFilter) {
        for (var key in dataAlumni) {
            if (dataAlumni[key].jurusan === jurusanFilter) {
                filteredData.push(dataAlumni[key]);
            }
        }
    } else {
        filteredData = Object.values(dataAlumni);
    }

    var bekerjaData = [];
    var melanjutkanPendidikanData = [];
    var tidakBekerjaData = [];
    var years = Object.keys(dataAlumni);

    years.forEach(function(year) {
        var yearData = dataAlumni[year];

        bekerjaData.push(yearData.status_1);
        melanjutkanPendidikanData.push(yearData.status_2);
        tidakBekerjaData.push(yearData.status_3);
    });

    var barHeight = 65;
    var totalBars = years.length;
    var chartHeight = totalBars * barHeight;

    var options = {
        series: [{
            name: 'Bekerja',
            data: bekerjaData
        }, {
            name: 'Melanjutkan Pendidikan',
            data: melanjutkanPendidikanData
        }, {
            name: 'Tidak Bekerja',
            data: tidakBekerjaData
        }],
        chart: {
            type: 'bar',
            height: chartHeight,
            background: '#e5e5e5',
        },
        title: {
            text: 'Alumni Career Status',
            align: 'center',
            style: {
                fontSize: '18px',
                color: '#000'
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                stacked: true, // Enable stacking
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: years,
            labels: {
                style: {
                    colors: '#000',
                }
            }
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            floating: false,
            fontSize: '12px',
            fontWeight: 400,
            labels: {
                colors: '#000',
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#000',
                }
            }
        },
    };

    document.addEventListener('DOMContentLoaded', function() {
        var chartContainer = document.querySelector("#statuskarir2");
        if (chartContainer) {
            var chart = new ApexCharts(chartContainer, options);
            chart.render();
        } else {
            console.error("Chart container not found.");
        }
    });
</script>
