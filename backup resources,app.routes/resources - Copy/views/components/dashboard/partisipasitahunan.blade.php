<div id="chartContainer" class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-800 w-full h-auto shadow-lg rounded">
    <div class="rounded-t mb-0 px-0 border-0">
        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h3 class="font-semibold text-base text-white">Partisipasi Alumni</h3>
            </div>
            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                <button class="bg-blue-500 dark:bg-gray-700 text-white active:bg-blue-600 dark:text-gray-100 dark:active:text-gray-300 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
                    Lihat Semua
                </button>
            </div>
        </div>
        <div class="block w-full overflow-x-auto px-4">
            <div id="Respone_rate_year" class="w-full font-sans" style="background-color: #fff; color: #2d3748;"></div>
        </div>
    </div>
</div>

<script>
    var dataPartisipasi = @json($persentasePerTahun);
    dataPartisipasi = dataPartisipasi.filter(item => item.tahun_lulus !== null);
    var tahun = dataPartisipasi.map(function(item) { return item.tahun_lulus; });
    var persentase = dataPartisipasi.map(function(item) { return item.persentase; });

    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Partisipasi Alumni (%)',
                data: persentase
            }],
            chart: {
                type: 'line', // Tipe chart menjadi line
                height: 350,
                background: '#2d3748', // Warna latar belakang grafik
                animations: {
                    enabled: true,
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        position: 'top', // Tempatkan label data di atas line
                    },
                    stroke: {
                        curve: 'smooth', // Membuat garis menjadi halus
                        width: 3, // Lebar garis
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return parseFloat(val).toFixed(1) + "%"; // Tambahkan simbol persen dan batasi angka di belakang koma
                },
                style: {},
                dropShadow: {}
            },
            xaxis: {
                categories: tahun,
                title: {
                    text: 'Tahun Kelulusan',
                    style: {
                        color: '#fff' // Warna putih untuk teks
                    }
                },
                labels: {
                    style: {
                        colors: '#fff' // Warna label sumbu X
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Persentase Partisipasi (%)',
                    style: {
                        color: '#fff' // Warna putih untuk teks
                    }
                },
                labels: {
                    style: {
                        colors: '#fff',
                    },
                    formatter: function (val) {
                        return parseFloat(val).toFixed(2) + "%"; // Format label sumbu Y
                    }
                }
            },
            title: {
                text: 'Response Rate By Graduate Year',
                align: 'center',
                style: {
                    fontSize: '18px',
                    color: '#fff' // Warna judul tetap putih
                }
            },
            colors: ['#1E90FF'], // Warna garis
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#Respone_rate_year"), options);
        chart.render();
    });
</script>
