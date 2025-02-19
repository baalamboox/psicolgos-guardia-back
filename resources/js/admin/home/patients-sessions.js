import Chart from 'chart.js/auto';

const patientsSessionsContainer = document?.querySelector('#patientsSessionsContainer');

async function getMetrics() {
    try {
        const apiSegmentURL = '/admin/metrics-login';
        const response = await axios.get(`${APP_URL + apiSegmentURL  }`);
        let metricsData = response.data.data;
        let valuesPatients = Object.values(metricsData).reverse();
        let adminsArray = [];
        let psychologistsArray = [];
        let patientsArray = [];

        for (let i = 0; i < valuesPatients.length; i++) 
        {
            adminsArray[i] = valuesPatients[i].admin;
            psychologistsArray[i] = valuesPatients[i].psychologist;
            patientsArray[i] = valuesPatients[i].patient;
        }
        
        const patientsSessionsConfig = {
            type: 'line',
            data: {
                labels: Object.keys(metricsData).reverse(),
                datasets: [
                    {
                        label: 'Pacientes',
                        backgroundColor: '#0694a2',
                        borderColor: '#0694a2',
                        data: patientsArray,
                        fill: false,
                    },
                    {
                        label: 'Psicólogos',
                        fill: false,
                        backgroundColor: '#7e3af2',
                        borderColor: '#7e3af2',
                        data: psychologistsArray,
                    },
                    {
                        label: 'Administradores',
                        backgroundColor: '#D53F8C',
                        borderColor: '#D53F8C',
                        data: adminsArray,
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
        patientsSessionsContainer && new Chart(patientsSessionsContainer, patientsSessionsConfig);
    } catch (error) {
        console.log(error);
    }
}

getMetrics();
