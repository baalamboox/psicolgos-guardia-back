@extends('layouts.app')
@section('title', 'Métricas')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Métricas</h2>
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Historial clínico</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Día a día</h4>
        <canvas id="medicalHistory"></canvas>
    </div>
    {{-- <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Experiencias traumáticas más comunes</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso sexual</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalSexualAbuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="sexualAbuseByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="sexualAbuseBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso físico</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalFisicAbuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="fisicAbuseByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="fisicAbuseBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso emocional</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalEmotionalAbuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="emotionalAbuseByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="emotionalAbuseBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Violencia doméstica</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalDomesticViolence"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="domesticViolenceByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="domesticViolenceBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Accidentes graves</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalSeriousAccidents"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="seriousAccidentsByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="seriousAccidentsBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Desastres naturales</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalNaturalDisasters"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="naturalDisastersByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="naturalDisastersBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Combates militares</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalMilitaryCombats"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="militaryCombatsByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="militaryCombatsBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abandono o perdida de seres queridos</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalAbandonmentLossLovedOne"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="abandonmentLossLovedOneByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="abandonmentLossLovedOneBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Asaltos o agresiones</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalAssaults"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="assaultsByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="assaultsBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Experiencias de discriminación o acoso</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalDescrimination"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="descriminationByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="descriminationBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Abuso de sustancias</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalSubstanceAbuse"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="substanceAbuseByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="substanceAbuseBySex"></canvas>
            </div>
        </div>
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Eventos médicos traumáticos</h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">General</h4>
                <canvas id="generalTraumaticMedicalEvents"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por edad</h4>
                <canvas id="traumaticMedicalEventsByAge"></canvas>
            </div>
            <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Por sexo</h4>
                <canvas id="traumaticMedicalEventsBySex"></canvas>
            </div>
        </div>
    </div> --}}
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Total de pacientes por rango de edad</h3>
    <div class="min-w-0 p-8 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="mx-auto" style="width: 500px">
            <canvas id="patientsByAgeRange"></canvas>
        </div>
        
    </div>
@endsection
