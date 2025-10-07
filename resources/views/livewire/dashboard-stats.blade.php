<div>
    <h4 class="mb-4 text-primary fw-bold">📅 Filtrer par Date</h4>

    <form class="row g-3 mb-4 align-items-center">
        <div class="col-md-3">
            <label for="startDate" class="form-label">Date de début</label>
            <input id="startDate" type="date" wire:model="startDate" class="form-control" />
        </div>
        <div class="col-md-3">
            <label for="endDate" class="form-label">Date de fin</label>
            <input id="endDate" type="date" wire:model="endDate" class="form-control" />
        </div>
    </form>

    {{-- Notification si en panne > 50 --}}
    @if($brokenCount > 50)
        <div class="alert alert-danger shadow-sm animate__animated animate__shakeX mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <strong>Attention :</strong> Plus de 50 articles sont en panne ! Intervention urgente recommandée.
        </div>
    @endif

    {{-- Cartes statistiques --}}
    <div class="row g-4 mb-5">
        <x-dashboard-card color="success" icon="boxes" title="Total Articles" :value="$totalArticles" />
        <x-dashboard-card color="info" icon="check-circle" title="Disponibles" :value="$availableCount" />
        <x-dashboard-card color="warning" icon="truck" title="Affectés" :value="$assignedCount" />
        <x-dashboard-card color="danger" icon="tools" title="En Panne" :value="$brokenCount" />
    </div>

    {{-- Graphiques --}}
    <div class="row gy-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold fs-5">
                    <i class="bi bi-bar-chart-fill me-2"></i> Top 5 Articles les plus affectés
                </div>
                <div class="card-body">
                    <canvas id="topArticlesChart" height="180"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-bold fs-5">
                    <i class="bi bi-pie-chart-fill me-2"></i> Répartition des Stock Items
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="stockChart" height="220" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const barCtx = document.getElementById('topArticlesChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($topArticles->pluck('nom')),
                    datasets: [{
                        label: 'Nombre d’affectations',
                        data: @json($topArticles->pluck('total')),
                        backgroundColor: ['#0B8A3C', '#29C9E0', '#F4A623', '#dc3545', '#6f42c1'],
                        borderRadius: 8,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: '#e9ecef'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });

            const pieCtx = document.getElementById('stockChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($stockLabels),
                    datasets: [{
                        label: 'Stock',
                        data: @json($stockData),
                        backgroundColor: ['#0B8A3C', '#F4A623', '#dc3545'],
                        borderColor: '#fff',
                        borderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        duration: 1200,
                        easing: 'easeOutBounce'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#495057',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    return label + ': ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</div>
