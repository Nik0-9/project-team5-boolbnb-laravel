import { Chart } from 'chart.js/auto';
//import 'chartjs-adapter-date-fns';

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('dailyViewsChart')) {
        function createChart(ctx, type, data, options) {
            return new Chart(ctx, {
                type: type,
                data: data,
                options: options
            });
        }

        function getDaysInMonth() {
            const now = new Date();
            const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
            let days = [];
            for (let i = 1; i <= daysInMonth; i++) {
                days.push(i.toString().padStart(2, '0'));
            }
            return days;
        }

        // Dati dal backend
        const dailyViewsData = JSON.parse(document.getElementById('dailyViewsData').textContent);
        const apartments = JSON.parse(document.getElementById('apartmentsData').textContent);
        const totalViewsPerApartment = JSON.parse(document.getElementById('totalViewsPerApartmentData').textContent);

        const dailyViewsLabels = getDaysInMonth();

        const datasets = apartments.map((apartment, index) => {
            const views = dailyViewsLabels.map(day => {
                const dayKey = `${new Date().getFullYear()}-${(new Date().getMonth() + 1).toString().padStart(2, '0')}-${day}`;
                return dailyViewsData[dayKey] && dailyViewsData[dayKey][apartment.id] ? dailyViewsData[dayKey][apartment.id] : 0;
            });

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
            labels: dailyViewsLabels,
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

        const apartmentLabels = apartments.map(apartment => apartment.name);
        const totalViewsCounts = apartments.map(apartment => totalViewsPerApartment[apartment.id] || 0);

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
    }
});