@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <h1>DASHBOARD</h1>
    </div>

    <div class="content-body" style="background-color: #fff; padding: 40px;">
        <div
            style="display: flex; flex-direction: row; justify-content: space-around; align-items: flex-start; gap: 40px; margin-top: 20px; flex-wrap: wrap;">
            <div style="width: 100%; max-width: 45%; min-width: 400px; text-align: center;">
                <h2
                    style="font-size: 20px; font-weight: normal; margin-bottom: 30px; color: #000; font-family: Arial, sans-serif;">
                    DATA KEPATUHAN WAJIB PAJAK AIR TANAH</h2>
                <canvas id="kepatuhanChart"></canvas>
            </div>

            <div style="width: 100%; max-width: 45%; min-width: 400px; text-align: center;">
                <h2
                    style="font-size: 20px; font-weight: normal; margin-bottom: 30px; color: #000; font-family: Arial, sans-serif;">
                    STATUS PENGAWASAN PAJAK AIR TANAH</h2>
                <canvas id="pengawasanChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const patuh = {{ $patuh ?? 0 }};
            const tidakPatuh = {{ $tidakPatuh ?? 0 }};
            const sudah = {{ $selesai ?? 0 }};
            const belum = {{ $belum ?? 0 }};

            Chart.defaults.font.family = 'Arial, sans-serif';
            Chart.defaults.font.size = 14;
            Chart.defaults.font.weight = 'bold';
            Chart.defaults.color = '#000';

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                weight: 'normal',
                                size: 12
                            }
                        },
                        border: {
                            display: true,
                            color: '#000'
                        },
                        grid: {
                            display: true,
                            color: '#e5e5e5'
                        }
                    },
                    x: {
                        border: {
                            display: true,
                            color: '#ccc'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            };

            const ctx1 = document.getElementById('kepatuhanChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['PATUH', 'TIDAK PATUH'],
                    datasets: [{
                        data: [patuh, tidakPatuh],
                        backgroundColor: [
                            '#0070c0',
                            '#9bb959'
                        ],
                        barThickness: 100
                    }]
                },
                options: chartOptions
            });

            const ctx2 = document.getElementById('pengawasanChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['SUDAH', 'BELUM'],
                    datasets: [{
                        data: [sudah, belum],
                        backgroundColor: [
                            '#0070c0',
                            '#9bb959'
                        ],
                        barThickness: 100
                    }]
                },
                options: chartOptions
            });
        });
    </script>
@endsection
