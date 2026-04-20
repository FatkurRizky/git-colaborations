@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Ringkasan</h1>
                <p class="text-sm text-slate-500">Pantau performa kas dan selisih harian Anda.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('rekon.export.pdf') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Ekspor PDF
                </a>

                <a href="{{ route('rekon.export.excel') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ekspor Excel
                </a>

                <a href="{{ route('rekon-kas.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    + Input Rekon
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Kas Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1 font-mono text-emerald-600">
                    Rp{{ number_format($totalKasHariIni, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status Terakhir</p>
                <div class="mt-2">
                    <span
                        class="px-3 py-1 bg-green-100 text-green-700 text-xs font-black rounded-lg uppercase">{{ strtoupper($statusTerakhir) }}</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Selisih (Bulan Ini)</p>
                <h3
                    class="text-2xl font-black mt-1 font-mono {{ $totalSelisihBulanIni < 0 ? 'text-red-600' : 'text-green-600' }}">
                    @if ($totalSelisihBulanIni < 0)
                        -Rp {{ number_format(abs($totalSelisihBulanIni), 0, ',', '.') }}
                    @else
                        Rp {{ number_format($totalSelisihBulanIni, 0, ',', '.') }}
                    @endif
                </h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Grafik Tren Selisih Kas</h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase">7 Hari
                    Terakhir</span>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="rekonChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('rekonChart').getContext('2d');

            // Buat gradien untuk background chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Selisih (Rp)',
                        data: {!! json_encode($chartData) !!},

                        borderColor: '#10b981',
                        borderWidth: 4,
                        pointBackgroundColor: function(context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value < 0 ? '#f5930b' : '#10b981'
                        },
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 10,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },

                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.95)',
                            padding: 20,
                            bodyFont: {
                                size: 14
                            },
                            titleFont: {
                                size: 14,
                                weight: 'bold',
                                family: 'sans-serif'
                            },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    let status = value < 0 ? 'Kurang' : (value > 0 ? 'Lebih' : 'Sesuai')
                                    let formatUang = 'Rp ' + Math.abs(value).toLocaleString('id-ID')
                                    return `Status: Selisih ${status} | ${value < 0 ? '-' : ''}${formatUang}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'TANGGAL REKAP',
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    weight: 'bold',
                                    family: 'sans-serif'
                                }
                            }
                        },
                        y: {
                            grid: {
                                borderDash: [10, 10],
                                color: '#e2e8f0'
                            },
                            ticks: {
                                callback: value => 'Rp ' + value.toLocaleString('id-ID')
                            },
                            title: {
                                display: true,
                                text: 'NOMINAL SELISIH',
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    weight: 'bold',
                                    family: 'sans-serif'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
