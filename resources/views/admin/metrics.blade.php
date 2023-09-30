@extends('layouts.app')
@section('title', 'Métricas')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Métricas</h2>
    <!-- Cards -->
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Historial clínico</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Día a día</h4>
        <canvas id="medical_history"></canvas>
    </div>
    <!-- Cards -->
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Experiencias traumáticas</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso sexual</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="general_sexual_abuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="sexual_abuse_by_age"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="sexual_abuse_by_sex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso físico</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="general_fisic_abuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="fisic_abuse_by_age"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="fisic_abuse_by_sex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso emocional</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="general_emotional_abuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="emotional_abuse_by_age"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="emotional_abuse_by_sex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Violencia doméstica</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="general_domestic_violence"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="domestic_violence_by_age"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="domestic_violence_by_sex"></canvas>
            </div>
        </div>
    </div>
@endsection
