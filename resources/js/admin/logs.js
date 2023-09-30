import { Grid, html } from 'gridjs';
import "gridjs/dist/theme/mermaid.css";
new Grid({
    columns: ['Acción', 'Detalles', 'Fecha'],
    data: [
      [html('<h1 class="text-red-800">Hola</h1>'), 'john@example.com', '(353) 01 222 3333'],
      ['Mark', 'mark@gmail.com',   '(01) 22 888 4444']
    ],
    className: {
        table: 'bg-gray-800'
    },
    style: {
        table: {
            background: 'red'
        }
    },
    language: {
        'search': {
          'placeholder': '🔍 Search...'
        },
        'pagination': {
          'previous': '⬅️',
          'next': '➡️',
          'showing': '😃 Displaying',
          'results': () => 'Records'
        }
      },
    pagination: true
}).render(document.getElementById('wrapper'));
