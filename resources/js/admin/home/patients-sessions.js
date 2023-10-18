import Chart from 'chart.js/auto';

const patientsSessionsConfig = {
    type: 'line',
    data: {
        labels: ['20/10/2023', '21/10/2023', '22/10/2023', '23/10/2023', '24/10/2023', '25/10/2023', '26/10/2023'],
        datasets: [
            {
                label: 'Pacientes',
                backgroundColor: '#0694a2',
                borderColor: '#0694a2',
                data: [10, 32, 40, 54, 30, 50, 10],
                fill: false,
            },
            {
                label: 'Psicólogos',
                fill: false,
                backgroundColor: '#7e3af2',
                borderColor: '#7e3af2',
                data: [24, 50, 64, 74, 52, 51, 65],
            },
            {
                label: 'Administradores',
                backgroundColor: '#D53F8C',
                borderColor: '#D53F8C',
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

document.querySelector('#patientsSessionsContainer') && new Chart(document.querySelector('#patientsSessionsContainer'), patientsSessionsConfig);
