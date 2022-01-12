@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <!-- Box 1 -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $categories }}</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-th"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">
                    Show <i class="fas fa-chevron-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Box 2 -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $products }}</h3>
                    <p>Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('products.index') }}" class="small-box-footer">
                    Show <i class="fas fa-chevron-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Box 3 -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $clients }}</h3>
                    <p>Clients</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <a href="{{ route('clients.index') }}" class="small-box-footer">
                    Show <i class="fas fa-chevron-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Box 4 -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $administrators }}</h3>
                    <p>Administrators</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <a href="{{ route('users.index') }}" class="small-box-footer">
                    Show <i class="fas fa-chevron-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card bg-gradient-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Sales Graph
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <canvas class="chart" id="line-chart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

<!-- Sales Graph Chart -->
<script>
    $(function() {
        var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
        // $('#revenue-chart').get(0).getContext('2d');

        var salesGraphChartData = {
            labels: [
                @foreach ($salesGraph as $data)
                '{{ $data->year . "-" . $data->month }}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Total Profit',
                    fill: false,
                    borderWidth: 2,
                    lineTension: 0,
                    spanGaps: true,
                    borderColor: '#efefef',
                    pointRadius: 3,
                    pointHoverRadius: 7,
                    pointColor: '#efefef',
                    pointBackgroundColor: '#efefef',
                    data: [
                        @foreach($salesGraph as $data)
                        {{ $data->profit }},
                        @endforeach
                    ]
                }
            ]
        }

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#efefef'
                    },
                        gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 500,
                        fontColor: '#efefef'
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false
                    }
                }]
            }
        }

        new Chart(salesGraphChartCanvas, {
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        })
    })
</script>
@endsection
