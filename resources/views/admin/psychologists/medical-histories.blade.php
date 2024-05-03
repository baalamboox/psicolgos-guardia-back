@extends('layouts.app')
@section('title', 'Historiales clínicos')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Historiales clínicos</h2>
    <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">Pacientes de {{ ucwords($psychologist->names . ' ' . $psychologist->first_surname) }}</h3>
    <div class="min-w-0 p-4 mb-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        @if(!$patients->isEmpty())
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($patients as $patient)
                <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-700">
                    <img class="w-full h-40 object-cover object-center" src="{{ asset($patient->profile_photo) }}" alt="" loading="lazy">
                    <div class="p-4">
                        <p class="text-purple-600 font-extrabold">Folio: <span class="font-light text-black dark:text-white">{{ $patient->id }}</span></p>
                        <h2 class="font-extrabold text-lg text-center my-4 dark:text-white">{{ ucwords($patient->names . ' ' . $patient->first_surname) }}</h2>
                        <div class="mb-5">
                            @if($patient->age != null)
                            <p class="font-bold text-purple-600">Edad: <span class="font-light text-black dark:text-white">{{ $patient->age }}</span></p>
                            @endif
                            @if($patient->sex != null)
                            <p class="font-bold text-purple-600">Sexo: <span class="font-light text-black dark:text-white">{{ ucwords($patient->sex) }}</span></p>
                            @endif
                        </div>
                        <a href="/admin/patients/medical-history/{{ $patient->id }}" class="flex items-center justify-evenly w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 -960 960 960">
                                <path d="M320-200h320v-80H320v80Zm0-120h320v-80H320v80Zm160-148q66-60 113-106.5t47-97.5q0-36-26-62t-62-26q-21 0-40.5 8.5T480-728q-12-15-31.5-23.5T408-760q-36 0-62 26t-26 62q0 51 45.5 96T480-468ZM720-80H240q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80Zm-480-80h480v-640H240v640Zm0 0v-640 640Z"/>
                            </svg>
                            Ver historial completo
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div>
            <div class="text-center">
                <img src="{{ asset('img/backgrounds/error-medical-histories.png') }}" alt="" class="mx-auto" width="250" loading="lazy" />
                <h3 class="font-light text-2xl mt-5 dark:text-white">¡Ups! No se encontraron historiales clínicos.</h3>
            </div>
        </div>
        @endif
    </div>
@endsection