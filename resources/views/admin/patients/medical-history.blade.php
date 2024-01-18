@extends('layouts.app')
@section('title', 'Historial medico')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Historial clínico</h2>
    <div class="min-w-0 p-8 bg-white rounded-lg shadow-xs dark:bg-gray-800"">
        <div class="bg-gray-100 p-4">
            <div class="grid grid-cols-4">
                <div class="justify-center items-center hidden lg:flex">
                    <img src="{{ asset($data[0]->profile_photo) }}" alt="" class="object-cover w-40 h-40 ml-4 mr-4 my-2 rounded-full shadow-lg" />
                </div>
                <div class="col-span-4 lg:col-span-3">
                    <span class="block text-right"><strong class="text-lg text-purple-600">Folio: </strong>{{ $data[0]->medicalHistory->id }}</span>
                    <div class="flex justify-center items-center lg:hidden">
                        <img src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f" alt="" class="object-cover w-40 h-40 ml-4 mr-4 my-2 rounded-full shadow-lg" />
                    </div>
                    <span class="block text-center my-8"><strong class="text-lg text-gray-600">Fecha ingreso: </strong>{{ $data[0]->medicalHistory->admission_date }}</span>
                    <span class="block"><strong class="text-lg text-gray-600">Paciente: </strong>{{ ucwords($data[0]->userPersonalData->names . ' ' . $data[0]->userPersonalData->first_surname . ' ' . $data[0]->userPersonalData->second_surname) }}</span>
                    <span class="block"><strong class="text-lg text-gray-600">Edad: </strong>{{ $data[0]->userPersonalData->age }}</span>
                    <span class="block"><strong class="text-lg text-gray-600">Sexo: </strong>{{ $data[0]->userPersonalData->sex }}</span>
                    <span class="block"><strong class="text-lg text-gray-600">Genero: </strong>{{ $data[0]->userPersonalData->gender }}</span>
                </div>
            </div>
            <div class="grid grid-flow-row mt-8">
                <strong class="text-lg text-gray-600">Descripción de problematica actual</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->current_problematic_description }}
                </div>
                <strong class="text-lg text-gray-600">Diagnóstico provisional</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->provisional_diagnosis }}
                </div>
                <strong class="text-lg text-gray-600">Evaluación clínica</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->clinical_evaluation }}
                </div>
            </div>
            <div class="grid grid-cols-2 my-8">
                <div>
                    <strong class="text-lg text-gray-600">Consumo de sustancias</strong>
                    <ul class="list-disc pl-4 mt-2">
                        <li>Alcohol</li>
                        <li>Cocaína</li>
                        <li>Marihuana</li>
                    </ul>
                </div>
                <div>
                    <strong class="text-lg text-gray-600">Padecimientos</strong>
                    <ul class="list-disc pl-4 mt-2">
                        <li>Problemas cardíacos</li>
                        <li>Problemas renales</li>
                        <li>Problemas neurológicos</li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-flow-row mt-8">
                <strong class="text-lg text-gray-600">Antecedentes psicólogicos</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->psychological_history }}
                </div>
                <strong class="text-lg text-gray-600">Historia psicósocial</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->psychosocial_history }}
                </div>
                <strong class="text-lg text-gray-600">Historia medica</strong>
                <div class="w-full h-75 my-1">
                    {{ $data[0]->medicalHistory->medical_history }}
                </div>
            </div>
            <div class="grid grid-cols-2 my-8">
                <div>
                    <strong class="text-lg text-gray-600">Medicación</strong>
                    {{ $data[0]->medicalHistory->medication }}
                    {{-- <ul class="list-disc pl-4 mt-2">
                        <li>Medicamentos para la presión.</li>
                        <li>Medicamentos para conciliar el sueño.</li>
                        <li>Epinefrina</li>
                    </ul> --}}
                </div>
                <div>
                    <strong class="text-lg text-gray-600">Experiencias traumáticas</strong>
                    {{ $data[0]->medicalHistory->traumatic_experiences }}
                    {{-- <ul class="list-disc pl-4 mt-2">
                        <li>Conflictos militares</li>
                        <li>Abuso infantil</li>
                        <li>Traumas medicos</li>
                    </ul> --}}
                </div>
            </div>
            <div class="grid grid-cols-1 my-8">
                <div>
                    <strong class="text-lg text-gray-600">Plan de tratamiento</strong>
                        {{ $data[0]->medicalHistory->treatment_plan }}
                    {{-- <ul class="list-decimal pl-4 mt-2">
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia odio impedit porro suscipit cumque nihil doloribus praesentium, beatae reprehenderit. Corporis magni quam, eos illum inventore fugit ipsum rerum sequi natus?</li>
                        <li>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Soluta perspiciatis minus distinctio enim cupiditate consequatur tempora totam odio cum assumenda quas facilis dignissimos alias, placeat voluptas ab ducimus, neque ipsam.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quibusdam fugiat corporis eaque exercitationem ex accusamus quod molestias. Ratione illum officiis repellendus aliquid minus earum provident aperiam, eaque neque. Veritatis.</li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>
@endsection