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

    <!-- Includi Chart.js e chartjs-adapter-date-fns tramite CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Funzione per creare un grafico
            function createChart(ctx, type, data, options) {
                return new Chart(ctx, {
                    type: type,
                    data: data,
                    options: options
                });
            }

            // Genera tutti i giorni del mese corrente
            function getDaysInMonth() {
                const now = new Date();
                const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
                let days = [];
                for (let i = 1; i <= daysInMonth; i++) {
                    days.push(i.toString().padStart(2, '0'));
                }
                return days;
            }

            // Dati per il grafico delle views giornaliere nel mese corrente
            const dailyViewsData = @json($dailyViews);
            console.log('dailyViewsData:', dailyViewsData); // Debugging
            console.log('Keys in dailyViewsData:', Object.keys(dailyViewsData)); // Debugging

            const dailyViewsLabels = getDaysInMonth();
            console.log('dailyViewsLabels:', dailyViewsLabels); // Debugging

            const apartments = @json($apartments);
            console.log('apartments:', apartments); // Debugging

            // Crea dataset per ogni appartamento
            const datasets = apartments.map((apartment, index) => {
                const views = dailyViewsLabels.map(day => {
                    const dayKey = `${new Date().getFullYear()}-${(new Date().getMonth() + 1).toString().padStart(2, '0')}-${day}`;
                    const dayViews = dailyViewsData[dayKey] || {};
                    return dayViews[apartment.id] || 0;
                });
                console.log('views for apartment:', apartment.name, views); // Debugging

                const colors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
                return {
                    label: apartment.name,
                    data: views,
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length],
                    fill: false,
                    tension: 0.4
                };
            });

            const dailyViewsCtx = document.getElementById('dailyViewsChart').getContext('2d');
            createChart(dailyViewsCtx, 'line', {
                labels: dailyViewsLabels, // Mostra solo il giorno del mese sull'asse x
                datasets: datasets
            }, {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Giorni del Mese'
                        },
                        type: 'category',
                        ticks: {
                            color: 'rgba(75, 192, 192, 1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Numero di Visualizzazioni'
                        },
                        ticks: {
                            color: 'rgba(75, 192, 192, 1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgba(75, 192, 192, 1)'
                        }
                    }
                }
            });

            // Dati per il grafico a torta delle views totali per appartamento
            const totalViewsPerApartment = @json($totalViewsPerApartment);
            console.log('totalViewsPerApartment:', totalViewsPerApartment); // Debugging

            const apartmentLabels = apartments.map(apartment => apartment.name);
            console.log('apartmentLabels:', apartmentLabels); // Debugging

            const totalViewsCounts = apartments.map(apartment => totalViewsPerApartment[apartment.id] || 0);
            console.log('totalViewsCounts:', totalViewsCounts); // Debugging

            const totalViewsCtx = document.getElementById('totalViewsPieChart').getContext('2d');
            createChart(totalViewsCtx, 'pie', {
                labels: apartmentLabels,
                datasets: [{
                    label: 'Views Totali per Appartamento',
                    data: totalViewsCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }, {
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            color: 'rgba(75, 192, 192, 1)'
                        }
                    }
                }
            });
        });
    </script>
@endsection