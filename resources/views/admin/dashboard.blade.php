@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between my-4">
            <h1 class="h3 mb-0 text-gray-800 fs-1">Dashboard</h1>
        </div>
        
        @auth
            <h2>{{ __('Benvenuto, :name!', ['name' => Auth::user()->name]) }}</h2>
        @endauth
        <select name="apartment" id="message_apartment" class="form-control mb-2 mb-md-2 w-25 w-md-auto">
            <option value="">Seleziona appartamento</option>
            @foreach ($apartments as $apartment)
                <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
            @endforeach
        </select>

        

            <!-- 
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bolder fs-5 text-uppercase mb-2">
                                    guadagni (Mensili)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">€ 0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas  fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card  h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bolder fs-5  text-uppercase mb-2">
                                    Guadagni (Annuali)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">€ 0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas  fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0%</div>
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


            <div class="row">

                <div class="col-xl-8 col-lg-7">
                    <div class="card  mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold ">Panoramica Guadagni</h6>
                        </div>
                        <div class="card-body my-5">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 mb-4">

                    <div class="card  mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold ">Appartamenti</h6>
                            <div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($apartments as $apartment)
                                <div class="card text-bg-dark my-3 border-0 " style="height: 70px" id="card-dash">
                                    <img src="{{'storage/' . $apartment->cover_image }}" class="img-fluid"
                                        style="width: 100%; height: 100%; opacity: 0.8" alt="{{$apartment->name}}">
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

    </div> -->
    @endsection