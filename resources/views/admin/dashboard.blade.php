@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between my-4">
                <h1 class="h3 mb-0 text-gray-800 fs-1">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bolder fs-5 text-uppercase mb-2">
                                        guadagni (Mensili)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas  fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card  h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bolder fs-5  text-uppercase mb-2">
                                        Guadagni (Annuali)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas  fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card  h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bolder fs-5  text-uppercase mb-2">
                                        Attività
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas  fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card  h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bolder fs-5  text-uppercase mb-2">
                                        Richieste pendenti</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas  fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card  mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold ">Panoramica Guadagni</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body my-5">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card  mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold ">Fonti di reddito</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle "></i> Direct
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Social
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Referral
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-6 mb-4">

                    <!-- Project Card Example -->
                    <div class="card  mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold ">...</h6>
                            {{-- <a href="{{ route('admin.movies.index') }}" class="">Mostra tutti i film</a> --}}
                        </div>
                        <div class="card-body">
                            {{-- @foreach ($movies as $movie)
                            <div class="d-flex align-items-center pb-3">
                                <span class="pe-3">
                                    <img src="{{ $movie->thumb }}" alt="{{ $movie->title }}"
                                        style="width: 80px ;height: 100px">
                                </span>
                                <h4 class="font-weight-bold">{{ $movie->title }}
                                </h4>
                                <div class=" mb-4">

                                </div>
                            </div>
                        @endforeach --}}
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 mb-4">

                    <!-- Illustrations -->
                    <div class="card  mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold ">Appartamenti</h6>
                            <div>
                                {{-- <a href="{{ route('admin.rooms.index') }}" class="">Mostra le sale</a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($apartments as $apartment)
                                <div class="card text-bg-dark my-3 border-0 " style="height: 70px" id="card-dash">
                                    <img src="{{ $apartment->cover_image}}" class="img-fluid" style="width: 100%; height: 100%; opacity: 0.8" alt="{{$apartment->name}}">
                                    <div class="card-img-overlay p-2">
                                        <h5 class="card-title">{{ $apartment->name }}</h5>
                                        <p class="card-text">aggiunto il: {{ $apartment->created_at}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
