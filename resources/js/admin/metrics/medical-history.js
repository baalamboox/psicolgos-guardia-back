import Chart from 'chart.js/auto';

const medicalHistoriesContainer = document?.querySelector('#medicalHistory');

async function getMetricsMedicalHistories() {
    try {
        const apiSegmentURL = '/admin/metrics/medical-histories';
        const response = await axios.get(`${APP_URL + apiSegmentURL  }`);
        let dataMetricsMedicalHistories = response.data.data;
        let valuesMedicalHistories = Object.values(dataMetricsMedicalHistories).reverse();
        let createdArray = [];
        let updatedArray = [];

        for (let i = 0; i < valuesMedicalHistories.length; i++) 
        {
            createdArray[i] = valuesMedicalHistories[i].created;
            updatedArray[i] = valuesMedicalHistories[i].updated;
        }

        const medicalHistoryConfig = {
            type: 'line',
            data: {
                labels: Object.keys(dataMetricsMedicalHistories).reverse(),
                datasets: [
                    {
                        label: 'Creados',
                        backgroundColor: '#68d391',
                        borderColor: '#68d391',
                        data: createdArray,
                        fill: false,
                    },
                    {
                        label: 'Actualizados',
                        fill: false,
                        backgroundColor: '#f6e05e',
                        borderColor: '#f6e05e',
                        data: updatedArray,
                    },
                    // {
                    //     label: 'Eliminados',
                    //     backgroundColor: '#fc8181',
                    //     borderColor: '#fc8181',
                    //     data: [50, 70, 5, 10, 67, 73, 70],
                    //     fill: false,
                    // },
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
        medicalHistoriesContainer && new Chart(medicalHistoriesContainer, medicalHistoryConfig);
    } catch (error) {
        console.log(error);
    }
}

getMetricsMedicalHistories();
