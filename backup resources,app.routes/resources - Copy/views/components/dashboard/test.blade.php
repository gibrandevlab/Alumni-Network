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
            <div id="barChart1" class="w-full font-sans" style="background-color: #fff; color: #2d3748;"></div>
        </div>
    </div>
</div>
<script>
    // Ambil data dari backend
    var dataPartisipasi = @json($persentasePerTahun);

    // Filter data untuk menghapus entri dengan tahun_lulus null
    dataPartisipasi = dataPartisipasi.filter(item => item.tahun_lulus !== null);

    // Extract tahun dan persentase dari data
    var tahun = dataPartisipasi.map(function(item) { return item.tahun_lulus; });
    var persentase = dataPartisipasi.map(function(item) { return item.persentase; });

    // Render grafik bar setelah halaman siap
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Partisipasi Alumni (%)',
                data: persentase // Data presentasi partisipasi alumni
            }],
            chart: {
                type: 'bar', // Tipe chart menjadi bar
                height: 350,
                background: '#2d3748', // Warna latar belakang grafik
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // Tempatkan label data di atas bar
                    }
                }
            },
            dataLabels: {
                enabled: true, // Aktifkan label data
                formatter: function (val) {
                    return parseFloat(val).toFixed(2) + "%"; // Tambahkan simbol persen dan batasi angka di belakang koma
                },
                style: {
                    fontSize: '12px',
                    colors: ['#fff'] // Warna label
                }
            },
            xaxis: {
                categories: tahun, // Tahun kelulusan sebagai label
                title: {
                    text: 'Tahun Kelulusan',
                    style: {
                        color: '#fff' // Warna putih untuk teks
                    }
                },
                labels: {
                    style: {
                        colors: '#fff', // Warna label sumbu X
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
                        colors: '#fff', // Warna label sumbu Y
                    },
                    formatter: function (val) {
                        return parseFloat(val).toFixed(2) + "%"; // Format label sumbu Y menjadi dua angka di belakang koma
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
            colors: ['#1E90FF'], // Warna bar
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

        var chart = new ApexCharts(document.querySelector("#barChart1"), options);
        chart.render();

        // Render data columns
        var dataColumns = document.getElementById('dataColumns');
        dataPartisipasi.forEach(function(item) {
            dataColumns.innerHTML += `<div class="flex justify-between py-2">
                                            <div>${item.tahun_lulus}</div>
                                            <div>${item.persentase.toFixed(2)}%</div>
                                        </div>`;
        });

        // Mengubah warna teks berdasarkan latar belakang
        const chartContainer = document.getElementById('chartContainer');
        if (window.getComputedStyle(chartContainer).backgroundColor === 'rgb(45, 55, 72)') { // warna gelap
            chartContainer.querySelectorAll('h3, button, .flex > div').forEach(el => {
                el.classList.add('text-white'); // menambah warna putih pada teks
            });
        } else {
            chartContainer.querySelectorAll('h3, button, .flex > div').forEach(el => {
                el.classList.add('text-black'); // menambah warna hitam pada teks
            });
        }

        // Mengatur warna font semua tombol download menjadi hitam
        var downloadButtons = document.querySelectorAll('.apexcharts-menu-item');
        downloadButtons.forEach(function(button) {
            button.style.color = 'black'; // Mengatur warna font tombol menjadi hitam
        });
    });
</script>
