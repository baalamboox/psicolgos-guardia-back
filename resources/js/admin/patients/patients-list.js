import { Grid, html } from "gridjs";
import 'gridjs/dist/theme/mermaid.css';
new Grid({
    columns: ['Foto', 'Paciente', 'Datos generales', 'Historial clínico', 'Estado', 'Eliminar', 'Editar'],
    data: [
        [html(`<div class="relative mx-auto hidden w-8 h-8 mr-3 rounded-full md:block">
        <img src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ" alt="" class="object-cover w-full h-full rounded-full" loading="lazy" />
        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
    </div>`), 'Fernando Sebastian', 'datos', html(`<a class="flex text-xs gap-1 align-middle p-1 hover:bg-green-800 rounded w-20 mx-auto justify-center bg-red-500 text-white" href="/pacientes/historial-clinico/01">
    <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
    </svg>
    Ver
</a>`), html(`<a class="flex text-xs gap-1 align-middle p-1 hover:bg-green-800 rounded w-20 mx-auto justify-center bg-red-500 text-white" href="/pacientes/historial-clinico/01">
<svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
    <path d="M640-520v-80h240v80H640Zm-280 40q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z" />
</svg>
Eliminado
</a>`), html(`<a class="flex text-xs gap-1 align-middle p-1 hover:bg-red-600 rounded w-20 mx-auto justify-center bg-red-500 text-white" href="/pacientes/historial-clinico/01">
<svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
</svg>
Eliminar
</a>`), html(`<a class="flex text-xs gap-1 align-middle p-1 hover:bg-yellow-300 rounded w-20 mx-auto justify-center bg-yellow-200 text-white" href="/pacientes/historial-clinico/01">
<svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
    <path d="M200-200h56l345-345-56-56-345 345v56Zm572-403L602-771l56-56q23-23 56.5-23t56.5 23l56 56q23 23 24 55.5T829-660l-57 57Zm-58 59L290-120H120v-170l424-424 170 170Zm-141-29-28-28 56 56-28-28Z" />
</svg>
Editar
</a>`)],
    ],
    pagination: true,
    search: true,
    className: {
        table:  'bg-green-800'
    }
}).render(document.querySelector('#patientsList'));
