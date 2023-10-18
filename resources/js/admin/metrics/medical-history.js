import Chart from 'chart.js/auto';

const medicalHistoryConfig = {
    type: 'line',
    data: {
        labels: ['20/10/2023', '21/10/2023', '22/10/2023', '23/10/2023', '24/10/2023', '25/10/2023', '26/10/2023'],
        datasets: [
            {
                label: 'Creados',
                backgroundColor: '#68d391',
                borderColor: '#68d391',
                data: [10, 32, 40, 54, 30, 50, 10],
                fill: false,
            },
            {
                label: 'Actualizados',
                fill: false,
                backgroundColor: '#f6e05e',
                borderColor: '#f6e05e',
                data: [24, 50, 64, 74, 52, 51, 65],
            },
            {
                label: 'Eliminados',
                backgroundColor: '#fc8181',
                borderColor: '#fc8181',
                data: [50, 70, 5, 10, 67, 73, 70],
                fill: false,
            },
        ],
    },
    options: {
        responsive: true,
        legend: {
            display: false,
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true,
        },
        scales: {
            x: {
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Month',
                },
            },
            y: {
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value',
                },
            },
        },
    },
};

document.querySelector('#medicalHistory') && new Chart(document.querySelector('#medicalHistory'), medicalHistoryConfig);
