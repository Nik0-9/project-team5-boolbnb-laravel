@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Statistiche degli Appartamenti</h1>

        <div class="row">
            <!-- Grafico Views per Giorno nel Mese Corrente -->
            <div class="col-md-6 mb-4">
                <h2>Visualizzazioni per Giorno (Mese Corrente)</h2>
                <canvas id="dailyViewsChart"></canvas>
            </div>

            <!-- Grafico a Torta delle Views Totali per Appartamento -->
            <div class="col-md-6 mb-4">
                <h2>Visualizzazioni Totali per Appartamento</h2>
                <canvas id="totalViewsPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Dati JSON per i grafici -->
    <script id="dailyViewsData" type="application/json">{!! json_encode($dailyViews) !!}</script>
    <script id="apartmentsData" type="application/json">{!! json_encode($apartments) !!}</script>
    <script id="totalViewsPerApartmentData" type="application/json">{!! json_encode($totalViewsPerApartment) !!}</script>
@endsection