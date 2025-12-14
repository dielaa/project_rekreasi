@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">Welcome to Backoffice Page</h3>
        <div class="container mt-5">
            <h3>Statistics Dashboard</h3>

            <div class="row mt-4">

                <div class="col-6">
                    <h5>Ticket Purchase Data {{ now()->format('F') }}</h5>
                    <canvas id="chartBar"></canvas>
                </div>
                <div class="col-6">
                    <h5>Status Tiket</h5>
                    <div style="width: 280px; height: 280px; margin: 0 auto;">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @push('scripts')
        <script>
            let labelBar = [];
            let dataBar = [];
            let labelPie = [];
            let dataPie = [];

            $(function () {
                $.ajax({
                    url: "{{ route('dashboard.ticket.chart') }}",
                    method: "GET",
                    success: function (res) {
                        labelBar = res.labels;
                        dataBar = res.data;
                        chartBar();
                    },
                    error: function () {
                        alert('Bar chart gagal dimuat');
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.ticket.status') }}",
                    method: "GET",
                    success: function (res) {
                        labelPie = res.labels;
                        dataPie = res.data;
                        chartPie();
                    },
                    error: function () {
                        alert('Pie chart gagal dimuat');
                    }
                });

            });

            function chartBar() {
                const ctx = document.getElementById('chartBar');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelBar,
                        datasets: [{
                            label: 'Penjualan Tiket Bulan Ini',
                            data: dataBar,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            function chartPie() {
                const ctx2 = document.getElementById('chartPie');
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: labelPie,
                        datasets: [{
                            data: dataPie,
                            backgroundColor: [
                                'rgb(54,162,235)',
                                'rgb(255,99,132)'
                            ]
                        }]
                    }
                });
            }
        </script>
    @endpush