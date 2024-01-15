@extends('layouts.app')
@section('title', 'Psicólogos')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Psicólogos</h2>
    @if(session('existPsychologists') == false)
    <div class="text-center">
        <img src="{{ asset('img/backgrounds/not-found.png') }}" alt="" class="mx-auto" />
        <h3 class="font-light text-2xl dark:text-white">¡Ups! No hay psicólogos aún.</h3>
    </div>
    @else
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Listado de psicólogos</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs">
        <div id="psychologistsList"></div>
    </div>
    @endif
@endsection