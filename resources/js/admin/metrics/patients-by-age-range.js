import Chart from "chart.js/auto";

const patientsByAgeRangeConfig = {
    type: 'doughnut',
    data: {
        labels: [
            'Niños',
            'Adolescentes',
            'Adultos',
            'Mayores',
        ],
        datasets: [{
            label: 'Cantidad',
            data: [25, 20, 10, 45],
            backgroundColor: [
                '#7209b7',
                '#f72582',
                '#4cc9f0',
                '#4361ee'
            ],
            hoverOffset: 4
        }]
    },
};

document.querySelector('#patientsByAgeRange') && new Chart(document.querySelector('#patientsByAgeRange'), patientsByAgeRangeConfig);
