@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Tableau de bord</h2>

    <div class="row g-4 mb-4">
        <!-- Total Articles -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Total Articles</h6>
                        <h4 class="fw-bold mb-0">{{ $totalArticles }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Mouvements -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-arrow-left-right fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Total Mouvements</h6>
                        <h4 class="fw-bold mb-0">{{ $totalMouvements }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Total -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-archive fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Stock Total</h6>
                        <h4 class="fw-bold mb-0">{{ $totalQuantite }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold">Évolution des mouvements</h5>
        </div>
        <div class="card-body">
            <canvas id="mouvementsChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = JSON.parse('{!! json_encode($labels) !!}');
    const data = JSON.parse('{!! json_encode($data) !!}');

    const config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Mouvements par mois',
                data: data,
                backgroundColor: 'rgba(11, 138, 60, 0.7)',
                borderColor: 'rgba(11, 138, 60, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    };

    new Chart(document.getElementById('mouvementsChart'), config);
</script>
@endsection