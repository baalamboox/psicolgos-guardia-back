@extends('layouts.app')
@section('title', 'Psicólogos')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Psicólogos</h2>
    <!-- Cards -->
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Listado de psicólogos</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <table id="psychologistsList"></table>
    </div>
@endsection