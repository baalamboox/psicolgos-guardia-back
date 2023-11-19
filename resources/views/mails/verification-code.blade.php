@extends('layouts.main')
@section('title', 'Verificación de código')
@section('body')               
<section class="max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-800">
    <main class="mt-8">
        <h2 class="text-gray-700 dark:text-gray-200">¡Hola {{ $names }}!,</h2>
        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
            Este es tu código de verificación:
        </p>
        <div class="flex items-center mt-4 gap-x-4">
            {{ $code }}
        </div>
        <p class="mt-8 text-gray-600 dark:text-gray-300">
            Gracias,<br>
            Psicólogos en Guardia
        </p>
    </main>
    <footer class="mt-8">
        <p class="text-gray-500 dark:text-gray-400">
            Este correo electrónico fue enviado por <span class="text-purple-600 dark:text-purple-400">jmg201098@gmail.com</span>.
        </p>
        <p class="mt-3 text-gray-500 dark:text-gray-400">© 2023 Psicólogos en Guardia. Todos los derechos reservados.</p>
    </footer>
</section>
@endsection
