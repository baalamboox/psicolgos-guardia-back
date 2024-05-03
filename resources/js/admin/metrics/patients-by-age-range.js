import Chart from "chart.js/auto";

const patientsByAgeRangeContainer = document?.querySelector('#patientsByAgeRange');

async function getMetricsPatientsByRangeAge() {
    try {
        const apiSegmentURL = '/admin/metrics/patients-by-range-age';
        const response = await axios.get(`${APP_URL + apiSegmentURL  }`);
        const data = response.data.data;
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
                    data: [data.children, data.teenagers, data.adults, data.greater],
                    backgroundColor: [
                        '#7209b7',
                        '#f72582',
                        '#4cc9f0',
                        '#4361ee'
                    ],
                    hoverOffset: 4
                }],
            },
        };
        patientsByAgeRangeContainer && new Chart(patientsByAgeRangeContainer, patientsByAgeRangeConfig);
    } catch (error) {
        console.log(error);
    }
}

getMetricsPatientsByRangeAge();
