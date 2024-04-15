import Chart from 'chart.js/auto';

async function getMetrics(){
    try {
        const reponse = await axios.get('http://localhost/admin/metrics-login');
        let metricsData = reponse.data.data;
        let valuesPatients = Object.values(metricsData);
        let adminsArray = [];
        let psychologistArray = [];
        let patientsArray = [];

        for (let i = 0; i < valuesPatients.length; i++) 
        {
            adminsArray[i] = valuesPatients[i].admin;
            psychologistArray[i] = valuesPatients[i].psychologist;
            patientsArray[i] = valuesPatients[i].patient;
        }
        
        const patientsSessionsConfig = {
            type: 'line',
            data: {
                labels: Object.keys(metricsData),
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
                        data: psychologistArray,
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
        document.querySelector('#patientsSessionsContainer') && new Chart(document.querySelector('#patientsSessionsContainer'), patientsSessionsConfig);
    } catch (error) {
        console.log(error);
    }
}
getMetrics();


