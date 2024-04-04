import { Grid, html } from "gridjs";
import 'gridjs/dist/theme/mermaid.css';

const profile = ({src}) => html(`
    <div class="relative mx-auto w-10 h-10 mr-3 rounded-full">
        <img src="${src}" alt="⚠️ Error de carga" class="object-cover w-full h-full rounded-full" loading="lazy" />
        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
    </div>
`);

const medicalHistory = ({href}) => html(`
    <a href="${href}" class="flex text-xs gap-1 align-middle p-1 rounded w-20 mx-auto justify-center border border-purple-100 bg-purple-100 text-purple-400 hover:border-purple-200 hover:bg-purple-200 hover:text-purple-600">
        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
        </svg>
        Ver
    </a>
`);

document.querySelector('#medicalHistories') && new Grid({
    columns: ['Foto', 'Paciente', 'Historial clínico',],
    data: [
        [profile({ src: 'https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ' }), 'Fernando Sebastian', medicalHistory({href: '/pacientes/historial-medico/1'}),],
        [profile({ src: 'https://images.pexels.com/photos/2853592/pexels-photo-2853592.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Isabel Rosales', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/7533347/pexels-photo-7533347.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Dante Guzmán', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Karol Velanova', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/1674752/pexels-photo-1674752.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Sandral Curibeña', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/1499327/pexels-photo-1499327.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Alondra Sanchéz', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/428361/pexels-photo-428361.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Leopoldo Rangel', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/1153334/pexels-photo-1153334.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Adolfo Gutierrez', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/64385/pexels-photo-64385.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Ismale Jiménez', medicalHistory({href: '#'}),],
        [profile({ src: 'https://images.pexels.com/photos/2726046/pexels-photo-2726046.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' }), 'Rosa de la Cruz', medicalHistory({href: '#'}),],
    ],
    pagination: true,
    search: true,
    language: {
        'search': {
            'placeholder': '🔍 Buscar historial clínico'
        },
        'pagination': {
            'previous': '<',
            'next': '>',
            'showing': 'Mostrando',
            'results': () => 'pacientes',
        }
    }
}).render(document.querySelector('#medicalHistories'));
