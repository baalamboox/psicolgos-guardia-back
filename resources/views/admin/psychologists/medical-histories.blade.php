@extends('layouts.app')
@section('title', 'Historiales clínicos')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Historiales clínicos</h2>
    <!-- Cards -->
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Pacientes de Renato Solís</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <table id="medicalHistories"></table>
    </div>
@endsection