import { Grid, html } from 'gridjs';
import { capitalLetters } from '../../capital-letters';
import 'gridjs/dist/theme/mermaid.css';

const user = ({src, name, firstSurname}) => html(`
    <div class="flex items-center text-sm">
        <div class="relative w-8 h-8 mr-3 rounded-full">
            <img src="${src}" alt="Foto" class="object-cover w-full h-full rounded-full" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
        <div>
            <p class="font-semibold">${name + ' ' + firstSurname}</p>
        </div>
    </div>
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

const recentUsersCover = document?.querySelector('#recentUsersCover');
const recentUsersContainer = document?.querySelector('#recentUsersContainer');

const recentUsers = new Grid({
    columns: ['Usuario', 'Rol', 'Estado', 'Fecha'],
    server: {
        url: `/admin/recent-users`,
        then: data => data.data.length == 0 ? [
            recentUsersCover.hidden = false,
            recentUsersContainer.hidden = true
        ] : data.data.map(users => [
            user({
                src: `${ APP_URL }/${ users.profile_photo }`,
                name: `${ capitalLetters({ words: users.user_personal_data.names }) }`,
                firstSurname: `${ capitalLetters({ words: users.user_personal_data.first_surname }) }`,
            }),
            `${ users.profile_id == 2 ? 'Paciente' : 'Psicólogo' }`,
            status({
                state: `${ users.state }`,
            }),
            `${ new Date(users.created_at).toISOString().slice(0, 10) }`,
            recentUsersContainer.hidden = false
        ]) 
    },
    pagination: true,
    language: {
        'pagination': {
            'previous': '<',
            'next': '>',
            'showing': 'Mostrando',
            'results': 'registros'
        }
    },
});

recentUsers.render(document.querySelector('#recentUsersContainer'));
