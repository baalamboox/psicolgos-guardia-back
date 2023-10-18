import {Grid, html} from 'gridjs';
import 'gridjs/dist/theme/mermaid.css';

const user = ({src, name, firstSurname}) => html(`
    <div class="flex items-center text-sm">
        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
            <img src="${src}" alt="Foto" class="object-cover w-full h-full rounded-full" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
        <div>
            <p class="font-semibold">${name + ' ' + firstSurname}</p>
        </div>
    </div>
`);
const state = ({state}) => html(`
    <div class="text-center">
        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">${state}</span>
    </div>
`);

const recentUsers = new Grid({
    columns: ['Usuario', 'Rol', 'Estado', 'Fecha'],
    data: [
        [
            user({
                src: 'https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ',
                name: 'Guillermo',
                firstSurname: 'Jiménez',
            }),
            'Administrador',
            state({
                state: 'Activo',
            }),
            '20/10/2023',
        ],
        [
            user({
                src: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&facepad=3&fit=facearea&s=707b9c33066bf8808c934c8ab394dff6',
                name: 'Yamilet',
                firstSurname: 'Hernández',
            }),
            'Psicólogo',
            state({
                state: 'Activo',
            }),
            '20/10/2023',
        ],
        [
            user({
                src: 'https://images.unsplash.com/photo-1551069613-1904dbdcda11?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ',
                name: 'Sarah',
                firstSurname: 'Rosales',
            }),
            'Administrador',
            state({
                state: 'Activo',
            }),
            '20/10/2023',
        ],
        [
            user({
                src: 'https://images.unsplash.com/photo-1551006917-3b4c078c47c9?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ',
                name: 'Julia',
                firstSurname: 'Robles',
            }),
            'Psicólogo',
            state({
                state: 'Activo',
            }),
            '20/10/2023',
        ],
    ],
    pagination: true,
    language: {
        'pagination': {
          'previous': '<',
          'next': '>',
          'showing': 'Mostrando',
          'results': () => 'registros'
        }
    }
});
document.querySelector('#recentUsersContainer') && recentUsers.render(document.querySelector('#recentUsersContainer'));
