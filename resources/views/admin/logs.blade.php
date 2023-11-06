@extends('layouts.app')
@section('title', 'Actividad')
@section('main')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Actividad</h2>
    <div class="min-w-0 p-8 bg-white rounded-lg shadow-xs dark:bg-gray-800"">
        <ol class="relative border-l border-gray-200 dark:border-gray-700">
            @foreach($data as $index => $getUserLog)
            <li class="mb-10 ml-6">
                <span class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-full text-purple-800 my-4 dark:text-white dark:bg-purple-900">
                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm80 240v-80h400v80H280Zm0 160v-80h280v80H280Z" />
                    </svg>
                </span>
                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $getUserLog->action }}
                    @if($index == 0)
                    <span class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2 py-1 rounded-full dark:bg-purple-900 dark:text-purple-300 ml-3">Último</span>
                    @endif
                </h3>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $getUserLog->created_at }}</time>
                <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                    {{ $getUserLog->details }}
                </p>
            </li>
            @endforeach
        </ol>
    </div>
@endsection
