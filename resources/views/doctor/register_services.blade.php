@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 p-4 sm:p-6 lg:p-8">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Registrar Nuevo Servicio</h2>
    
    <!-- Formulario para registrar un nuevo servicio -->
    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        
        <!-- Nombre del Servicio -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Nombre del Servicio</label>
            <input type="text" name="name" id="name" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" 
                   required>
        </div>
        
        <!-- Descripción del Servicio -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Descripción del Servicio</label>
            <textarea name="description" id="description" rows="4" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        
        <!-- Precio del Servicio -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Precio del Servicio</label>
            <input type="number" name="price" id="price" step="0.01" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" 
                   required>
        </div>
        
        <!-- Botón para guardar -->
        <div class="flex items-center justify-between">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Registrar Servicio
            </button>
        </div>
    </form>
</div>
@endsection
