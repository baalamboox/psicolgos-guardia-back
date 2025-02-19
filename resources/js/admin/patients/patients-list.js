import { Grid, html } from "gridjs";
import { capitalLetters } from '../../capital-letters';
import 'gridjs/dist/theme/mermaid.css';

const coverNoPatients = document?.querySelector('#coverNoPatients');
const containerPatientsList = document?.querySelector('#containerPatientsList');
const patientsList = document?.querySelector('#patientsList');

const profile = ({src}) => html(`
    <div class="flex items-center text-sm">
        <div class="relative mx-auto w-10 h-10 mr-3 rounded-full shadow-lg">
            <img src="${src}" alt="" class="object-cover w-full h-full rounded-full" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
    </div>
`);

const generalData = ({href}) => html(`
    <a href="${href}" class="flex text-xs gap-1 align-middle p-1 rounded w-20 mx-auto justify-center border border-gray-100 bg-gray-100 text-gray-400 border border-gray-300 shadow hover:border-gray-200 hover:bg-gray-200 hover:text-gray-600">
        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
        </svg>
        Ver
    </a>
`);

const medicalHistory = ({href}) => html(`
    <a href="${href}" class="flex text-xs gap-1 align-middle p-1 rounded w-20 mx-auto justify-center border border-purple-100 bg-purple-100 text-purple-400 border border-purple-300 shadow hover:border-purple-200 hover:bg-purple-200 hover:text-purple-600">
        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
        </svg>
        Ver
    </a>
`);

const status = ({state}) => state === 'activo' ? html(`
    <a class="flex text-xs gap-1 p-1 align-middle rounded w-25 mx-auto justify-center text-green-600">
        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18q30 0 58.5 3t55.5 9l-70 70q-11-2-21.5-2H400q-71 0-127.5 17T180-306q-9 5-14.5 14t-5.5 20v32h250l80 80H80Zm542 16L484-282l56-56 82 82 202-202 56 56-258 258ZM400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm10 240Zm-10-320q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Z" />
        </svg>
        Activo
    </a>
`) : html(`
    <a class="flex text-xs gap-1 p-1 align-middle rounded w-25 mx-auto justify-center text-red-600">
        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M640-520v-80h240v80H640Zm-280 40q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z" />
        </svg>
        Eliminado
    </a>
`);

patientsList && new Grid({
    columns: ['Foto', 'Paciente', 'Datos generales', 'Historial clínico', 'Estado'],
    server: {
        url:`${APP_URL}/admin/list-all-patients`,
        then: data => data.data.length != 0 ? (
            data.data.map(patient => [
                profile({ src: `${ APP_URL }/${ patient.profile_photo }` }),
                capitalLetters({ words: `${ patient.user_personal_data.names } ${ patient.user_personal_data.first_surname }` }),
                generalData({ href: `${APP_URL}/admin/patients/general-data/${ patient.id }` }),
                medicalHistory({ href: `${APP_URL}/admin/patients/medical-history/${ patient.id }` }),
                status({ state: patient.state })
            ])
        ) : [containerPatientsList.hidden = true, coverNoPatients.hidden = false],
    },
    pagination: {
        limit: 10
    },
    search: true,
    language: {
        'search': {
            'placeholder': '🔍 Buscar paciente'
        },
        'pagination': {
            'previous': '<',
            'next': '>',
            'showing': 'Mostrando',
            'results': () => 'pacientes',
        }
    }
}).render(patientsList);
