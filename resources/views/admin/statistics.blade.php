@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Statistiche degli Appartamenti</h1>
        <div class="row">
            <!-- Grafico Views per Giorno nel Mese Corrente -->
            <div class="col-md-6 mb-4">
                <h2>Visualizzazioni del mese di {{ ucfirst(\Carbon\Carbon::now()->locale('it')->translatedFormat('F')) }} </h2>
                <div class="d-flex align-items-center" style="min-height: 400px;">
                    <canvas id="dailyViewsChart" class="w-100"></canvas>
                </div>
            </div>
            <!-- Grafico a Torta delle Views Totali per Appartamento -->
            <div class="col-md-6 mb-4">
                <h2>Visualizzazioni Totali per Appartamento</h2>
                <div class="d-flex align-items-center" style="min-height: 400px;">
                    <canvas id="totalViewsPieChart" class="w-100"></canvas>
                </div>
            </div>
            <!-- Grafico Messaggi per Mese nell'Anno Corrente -->
            <div class="col-md-6 mb-4">
                <h2>Messaggi del {{ date('Y') }}</h2>
                <div class="d-flex align-items-center" style="min-height: 400px;">
                    <canvas id="monthlyMessagesChart" class="w-100"></canvas>
                </div>
            </div>
            <!-- Grafico a Torta dei Messaggi Totali per Appartamento -->
            <div class="col-md-6 mb-4">
                <h2>Messaggi Totali per Appartamento</h2>
                <div class="d-flex align-items-center" style="min-height: 400px;">
                    <canvas id="totalMessagesPieChart" class="w-100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Dati JSON per i grafici -->
    <script id="dailyViewsData" type="application/json">{!! json_encode($dailyViews) !!}</script>
    <script id="apartmentsData" type="application/json">{!! json_encode($apartments) !!}</script>
    <script id="totalViewsPerApartmentData" type="application/json">{!! json_encode($totalViewsPerApartment) !!}</script>
    <script id="monthlyMessagesData" type="application/json">{!! json_encode($monthlyMessages) !!}</script>
    <script id="totalMessagesPerApartmentData" type="application/json">{!! json_encode($totalMessagesPerApartment) !!}</script>
@endsection