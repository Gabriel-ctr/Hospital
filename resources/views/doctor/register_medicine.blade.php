<!-- resources/views/doctor/register_medicamentos.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Medicamento</h2>
        <form method="POST" action="{{ route('doctor.medicines.store') }}">
        @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="name" class="block text-gray-700 font-medium">Nombre del Medicamento</label>
                    <input type="text" name="name" id="name" required 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="form-group">
                    <label for="description" class="block text-gray-700 font-medium">Descripción</label>
                    <textarea name="description" id="description" required
                              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>

                <div class="form-group">
                    <label for="quantity" class="block text-gray-700 font-medium">Cantidad en Stock</label>
                    <input type="number" name="quantity" id="quantity" required 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="form-group">
                    <label for="price" class="block text-gray-700 font-medium">Precio por Unidad</label>
                    <input type="number" step="0.01" name="price" id="price" required 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Registrar Medicamento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
