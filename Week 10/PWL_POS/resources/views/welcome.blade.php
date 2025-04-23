@extends('layouts.template')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selamat datang di aplikasi PWL_POS</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <h5>Grafik Penjualan</h5>
            <canvas id="penjualanChart" width="400" height="150"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const penjualanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
                datasets: [{
                    label: 'Total Penjualan',
                    data: [120, 150, 180, 90, 200],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Penjualan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });
    </script>
@endsection

@section('script')

@endsection