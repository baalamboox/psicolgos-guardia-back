import Chart from 'chart.js/auto';
const general_sexual_abuse = {
    type: 'bar',
    data: {
        labels: [
            'Total',
        ],
        datasets: [{
            label: 'Pacientes',
            data: [65],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};
const sexual_abuse_by_age = {
    type: 'bubble',
    data: {
        datasets: [{
            label: 'First Dataset',
            data: [{
                x: 20,
                y: 30,
                r: 4
            }, {
                x: 100,
                y: 10,
                r: 4
            }],
            backgroundColor: 'rgb(255, 99, 132)'
        }]
    },
};
const sexual_abuse_by_sex = {
    type: 'doughnut',
    data: {
        labels: [
            'Femenino',
            'Masculino',
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    },
};
const general_fisic_abuse = {
    type: 'bar',
    data: {
        labels: [
            'Total',
        ],
        datasets: [{
            label: 'Pacientes',
            data: [65],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};
const fisic_abuse_by_age = {
    type: 'bubble',
    data: {
        datasets: [{
            label: 'First Dataset',
            data: [{
                x: 20,
                y: 30,
                r: 4
            }, {
                x: 100,
                y: 10,
                r: 4
            }],
            backgroundColor: 'rgb(255, 99, 132)'
        }]
    },
};
const fisic_abuse_by_sex = {
    type: 'doughnut',
    data: {
        labels: [
            'Femenino',
            'Masculino',
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    },
};
const general_emotional_abuse = {
    type: 'bar',
    data: {
        labels: [
            'Total',
        ],
        datasets: [{
            label: 'Pacientes',
            data: [65],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};
const emotional_abuse_by_age = {
    type: 'bubble',
    data: {
        datasets: [{
            label: 'First Dataset',
            data: [{
                x: 20,
                y: 30,
                r: 4
            }, {
                x: 100,
                y: 10,
                r: 4
            }],
            backgroundColor: 'rgb(255, 99, 132)'
        }]
    },
};
const emotional_abuse_by_sex = {
    type: 'doughnut',
    data: {
        labels: [
            'Femenino',
            'Masculino',
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    },
};
const general_domestic_violence = {
    type: 'bar',
    data: {
        labels: [
            'Total',
        ],
        datasets: [{
            label: 'Pacientes',
            data: [65],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};
const domestic_violence_by_age = {
    type: 'bubble',
    data: {
        datasets: [{
            label: 'First Dataset',
            data: [{
                x: 20,
                y: 30,
                r: 4
            }, {
                x: 100,
                y: 10,
                r: 4
            }],
            backgroundColor: 'rgb(255, 99, 132)'
        }]
    },
};
const domestic_violence_by_sex = {
    type: 'doughnut',
    data: {
        labels: [
            'Femenino',
            'Masculino',
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    },
};

window.general_sexual_abuse = new Chart(document.getElementById('general_sexual_abuse'), general_sexual_abuse);
window.sexual_abuse_by_age = new Chart(document.getElementById('sexual_abuse_by_age'), sexual_abuse_by_age);
window.sexual_abuse_by_sex = new Chart(document.getElementById('sexual_abuse_by_sex'), sexual_abuse_by_sex);
window.general_fisic_abuse = new Chart(document.getElementById('general_fisic_abuse'), general_fisic_abuse);
window.fisic_abuse_by_age = new Chart(document.getElementById('fisic_abuse_by_age'), fisic_abuse_by_age)
window.fisic_abuse_by_sex = new Chart(document.getElementById('fisic_abuse_by_sex'), fisic_abuse_by_sex);
window.general_emotional_abuse = new Chart(document.getElementById('general_emotional_abuse'), general_emotional_abuse);
window.emotional_abuse_by_age = new Chart(document.getElementById('emotional_abuse_by_age'), emotional_abuse_by_age);
window.emotional_abuse_by_sex = new Chart(document.getElementById('emotional_abuse_by_sex'), emotional_abuse_by_sex);
window.general_domestic_violence = new Chart(document.getElementById('general_domestic_violence'), general_domestic_violence);
window.domestic_violence_by_age = new Chart(document.getElementById('domestic_violence_by_age'), domestic_violence_by_age);
window.domestic_violence_by_sex = new Chart(document.getElementById('domestic_violence_by_sex'), domestic_violence_by_sex);
