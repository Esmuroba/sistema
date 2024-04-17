@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @can('home')
        <div class="row">
            <div class="col-md-12 col-lg-4 mb-4">
                <div class="card bg-transparent shadow-none">
                    <div class="d-flex align-items-end row">
                        <div class="card-body card-separator">
                            <h3>¡Bienvenid@, {{ $user->collaborator->first_name }}! 👋🏻 </h3>
                            <div class="col-12 col-lg-10 col-xxl-8">
                                <p>Te presentamos los datos más relevantes de la actividad dentro de la plataforma.</p>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                                <div class="d-flex align-items-center justify-content-center gap-3 me-4 me-sm-0">
                                    <span class=" bg-label-primary p-2 rounded">
                                        <i class="fa-solid fa-eye bx-sm"></i>
                                    </span>
                                    <div class="content-right">
                                        <p class="mb-0">Para ver más</p>
                                        <a href="{{ route('clients.all-requests') }}" class="btn btn-sm btn-primary">Ir a las Solicitudes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New Visitors & Activity -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body row g-4">
                        <div class="col-md-6 pe-md-4 card-separator">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="mb-0">Nuevos Clientes</h5>
                                <small>Semana Actual</small>
                            </div>
                            <div class="d-flex justify-content-between" style="position: relative;">
                                <div class="mt-auto">
                                    <h2 class="mb-2">{{ round($percentNewClients) }}%</h2>
                                    <small class="text-primary text-nowrap fw-medium">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </small>
                                </div>
                                <div id="newClientsChart" style="min-height: 120px;"></div>
                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 314px; height: 121px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="mb-0">Actividad Reciente</h5>
                                <small>Semana Actual</small>
                            </div>
                            <div class="d-flex justify-content-between" style="position: relative;">
                                <div class="mt-auto">
                                    <h2 class="mb-2">{{ round($percentNewRequests) }}%</h2>
                                    <small class="text-secondary text-nowrap fw-medium">
                                        <i class='bx bx-file'></i>
                                    </small>
                                </div>
                                <div id="activityChart" style="min-height: 120px;"></div>
                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 315px; height: 121px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ New Visitors & Activity -->

            {{-- <div class="col-lg-4 col-xxl-4 mb-4 order-3 order-xxl-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Shipment statistics</h5>
                            <small class="text-muted">Total number of deliveries 23.8k</small>
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;"> --}}
            {{--  --}}
            {{-- <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 538px; height: 295px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Total Income -->
            <div class="col-lg-12{{-- 8 --}} col-xxl-12{{-- 8 --}} mb-4 order-5 order-xxl-1">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Solicitudes Totales</h5>
                                {{-- <small class="card-subtitle">Resumen</small> --}}
                            </div>
                            <div class="card-body" style="position: relative;">
                                <div id="totalIncomeChart" style="min-height: 265px;">
                                    <div id="requestsChart"></div>
                                </div>
                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 484px; height: 290px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-0">Resumen</h5>
                                    {{-- <small class="card-subtitle">De las solicitudes</small> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="report-list">
                                    <div class="report-list-item rounded-2 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="report-list-icon badge bg-label-secondary shadow-sm me-2">
                                                <i class="fa-solid fa-file-circle-check bx-sm"></i>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Aprobadas</span>
                                                    <h5 class="mb-0">{{ $approvedRequests }}</h5>
                                                </div>
                                                {{-- <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="badge badge-center rounded-pill bg-secondary"> </span>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="report-list-item rounded-2 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="report-list-icon badge bg-label-danger shadow-sm me-2">
                                                <i class="fa-solid fa-file-circle-xmark bx-sm"></i>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Rechazadas</span>
                                                    <h5 class="mb-0">{{ $denyRequests }}</h5>
                                                </div>
                                                {{-- <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="badge badge-center rounded-pill bg-secondary"> </span>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="report-list-item rounded-2">
                                        <div class="d-flex align-items-center">
                                            <div class="report-list-icon badge bg-label-third shadow-sm me-2">
                                                <i class="fa-solid fa-file-circle-question bx-sm"></i>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Pendientes</span>
                                                    <h5 class="mb-0">{{ $awaitingRequests }}</h5>
                                                </div>
                                                {{-- <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="badge badge-center rounded-pill bg-secondary"> </span>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Income -->
            </div>
            <!--/ Total Income -->
        </div>
        <div class="row">
            {{-- <div class="col-sm-6 col-lg-6 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <div class="badge bg-label-warning p-2">
                                    <i class="fa-solid fa-hand-holding-dollar bx-sm"></i>
                                </div>
                            </div>
                            <h4 class="ms-1 mb-0">$4,679.00</h4>
                        </div>
                        <p class="mb-1">En Adelantos</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">+18.2%</span>
                            <small class="text-muted">que la última semana</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <div class="badge bg-label-primary p-2">
                                    <i class="fa-solid fa-money-bill-trend-up bx-sm"></i>
                                </div>
                            </div>
                            <h4 class="ms-1 mb-0">$8,596.00</h4>
                        </div>
                        <p class="mb-1">Ganancias</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">+8.7%</span>
                            <small class="text-muted">que la última semana</small>
                        </p>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i
                                        class="bx bx-git-repo-forked"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">27</h4>
                        </div>
                        <p class="mb-1">Deviated from route</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">+4.3%</span>
                            <small class="text-muted">than last week</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">13</h4>
                        </div>
                        <p class="mb-1">Late vehicles</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">-2.5%</span>
                            <small class="text-muted">than last week</small>
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
    @endcan

    {{-- Gráfica de Nuevos Clientes --}}
    <script>
        var dataClients = @json($numNewClients);
        var newClients = []

        dataClients.forEach(clients => {
            newClients.push(clients)

        });

        var options = {
            series: [{
                name: 'Clientes',
                data: newClients
            }],
            chart: {
                height: '100%',
                type: 'bar',
                toolbar: {
                    show: false
                },
            },
            grid: {
                show: false
            },
            colors: ['#3CB4D3'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: 15,
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#newClientsChart"), options);
        chart.render();
    </script>

    {{-- Gráfica de Actividad --}}
    <script>
        var dataRequests = @json($numNewRequests);
        var newRequests = []

        dataRequests.forEach(requests => {
            newRequests.push(requests)
        });

        var options = {
            series: [{
                name: 'Solicitudes',
                data: newRequests
            }],
            chart: {
                type: 'area',
                stacked: false,
                height: '100%',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            toolbar: {
                show: false
            },
            grid: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            colors: ['#C2EB0E'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0.35,
                    stops: [20, 100, 100, 100]
                },
            },
            xaxis: {
                categories: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                shared: true
            },
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#activityChart"), options);
        chart.render();
    </script>

    {{-- Gráfica de Solicitudes --}}
    <script>
        var options = {
            series: [{
                name: 'Solicitudes',
                data: [{{ $approvedRequests }}, {{ $denyRequests }}, {{ $awaitingRequests }}]
            }],
            chart: {
                height: 260,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            colors: [/* '#3CB4D3', */ '#C2EB0E', '#FF3E1D', '#22697A'],
            plotOptions: {
                bar: {
                    columnWidth: '75',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Aprobadas', 'Rechazadas', 'Pendientes'],
                labels: {
                    style: {
                        fontSize: '13px'
                    }
                }
            },
            noData: {
                text: 'Cargando...'
            }
        };

        var chart = new ApexCharts(document.querySelector("#requestsChart"), options);
        chart.render();
    </script>
@endsection
