import Chart from 'chart.js/auto';

class TraumaticExperiences {
    constructor({data, place}) {
        this.data = data;
        this.place = place;
    }
    general() {
        const generalConfig = {
            type: 'bar',
            data: {
                labels: [
                    'Total',
                ],
                datasets: [{
                    label: 'Pacientes',
                    data: this.data,
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
        return new Chart(this.place, generalConfig);
    }
    byAge() {
        const byAgeConfig = {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Pacientes',
                    data: this.data,
                    backgroundColor: 'rgb(255, 99, 132)'
                }]
            },
        };
        return new Chart(this.place, byAgeConfig);
    }
    bySex() {
        const bySexConfig = {
            type: 'doughnut',
            data: {
                labels: [
                    'Femenino',
                    'Masculino',
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: this.data,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                    hoverOffset: 4
                }]
            },
        };
        return new Chart(this.place, bySexConfig);
    }
}

document.querySelector('#generalSexualAbuse') && new TraumaticExperiences({data: [65], place: document.querySelector('#generalSexualAbuse')}).general();
document.querySelector('#sexualAbuseByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 } ], place: document.querySelector('#sexualAbuseByAge')}).byAge();
document.querySelector('#sexualAbuseBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#sexualAbuseBySex')}).bySex();

document.querySelector('#generalEmotionalAbuse') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalFisicAbuse')}).general();
document.querySelector('#fisicAbuseByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#fisicAbuseByAge')}).byAge();
document.querySelector('#fisicAbuseBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#fisicAbuseBySex')}).bySex();

document.querySelector('#generalEmotionalAbuse') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalEmotionalAbuse')}).general();
document.querySelector('#emotionalAbuseByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#emotionalAbuseByAge')}).byAge();
document.querySelector('#emotionalAbuseBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#emotionalAbuseBySex')}).bySex();

document.querySelector('#generalDomesticViolence') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalDomesticViolence')}).general();
document.querySelector('#domesticViolenceByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#domesticViolenceByAge')}).byAge();
document.querySelector('#domesticViolenceBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#domesticViolenceBySex')}).bySex();

document.querySelector('#generalSeriousAccidents') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalSeriousAccidents')}).general();
document.querySelector('#seriousAccidentsByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#seriousAccidentsByAge')}).byAge();
document.querySelector('#seriousAccidentsBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#seriousAccidentsBySex')}).bySex();

document.querySelector('#generalNaturalDisasters') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalNaturalDisasters')}).general();
document.querySelector('#naturalDisastersByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#naturalDisastersByAge')}).byAge();
document.querySelector('#naturalDisastersBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#naturalDisastersBySex')}).bySex();

document.querySelector('#generalMilitaryCombats') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalMilitaryCombats')}).general();
document.querySelector('#militaryCombatsByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#militaryCombatsByAge')}).byAge();
document.querySelector('#militaryCombatsBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#militaryCombatsBySex')}).bySex();

document.querySelector('#generalAbandonmentLossLovedOne') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalAbandonmentLossLovedOne')}).general();
document.querySelector('#abandonmentLossLovedOneByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#abandonmentLossLovedOneByAge')}).byAge();
document.querySelector('#abandonmentLossLovedOneBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#abandonmentLossLovedOneBySex')}).bySex();

document.querySelector('#generalAssaults') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalAssaults')}).general();
document.querySelector('#assaultsByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#assaultsByAge')}).byAge();
document.querySelector('#assaultsBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#assaultsBySex')}).bySex();

document.querySelector('#generalDescrimination') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalDescrimination')}).general();
document.querySelector('#descriminationByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#descriminationByAge')}).byAge();
document.querySelector('#descriminationBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#descriminationBySex')}).bySex();

document.querySelector('#generalSubstanceAbuse') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalSubstanceAbuse')}).general();
document.querySelector('#substanceAbuseByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#substanceAbuseByAge')}).byAge();
document.querySelector('#substanceAbuseBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#substanceAbuseBySex')}).bySex();

document.querySelector('#generalTraumaticMedicalEvents') && new TraumaticExperiences({data: [80], place: document.querySelector('#generalTraumaticMedicalEvents')}).general();
document.querySelector('#traumaticMedicalEventsByAge') && new TraumaticExperiences({data: [ { x: 10, y: 20, r: 4 }, { x: 40, y: 20, r: 4 } ], place: document.querySelector('#traumaticMedicalEventsByAge')}).byAge();
document.querySelector('#traumaticMedicalEventsBySex') && new TraumaticExperiences({data: [30, 50], place: document.querySelector('#traumaticMedicalEventsBySex')}).bySex();
