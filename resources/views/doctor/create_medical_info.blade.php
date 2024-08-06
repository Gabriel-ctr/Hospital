@extends('layouts.app')

@section('content')

<div class="container mx-auto mt-10 p-4 sm:p-6 lg:p-8">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Add Medical Information</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline"> There were some problems with your input.</span>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctor.medical_infos.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
        @csrf

        <select class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="patient_id" name="patient_id" required>
            <option value="">Select Patient</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" data-id="{{ $patient->id }}">{{ $patient->name }}</option>
            @endforeach
        </select>

        <select class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="appointment_date" name="appointment_date" required>
            <option value="">Select Appointment Date</option>
            @if(isset($appointments))
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment }}">{{ $appointment }}</option>
                @endforeach
            @endif
        </select>

        <div class="mt-6" id="medications-checkboxes">
    <label class="block text-gray-700 font-medium mb-2">Select Medications:</label>
    @if($medications->isNotEmpty())
        @foreach($medications as $medication)
            <div class="flex items-center mb-2">
                <input type="checkbox" name="medications[]" value="{{ $medication->id }}" id="medication_{{ $medication->id }}" data-price="{{ $medication->price }}" data-quantity="{{ $medication->quantity }}" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                <label for="medication_{{ $medication->id }}" class="ml-2 text-gray-700">{{ $medication->name }}</label>
                <input type="number" step="0.01" name="medication_prices[]" value="{{ $medication->price }}" readonly class="form-input ml-2 w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <input type="number" name="medication_quantities[]" min="1" max="{{ $medication->quantity }}" placeholder="Quantity" class="form-input ml-2 w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
        @endforeach
    @else
        <p class="text-gray-700">No medications available.</p>
    @endif
</div>

<div class="form-group">
    <label for="service" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Service</label>
    <select class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="service" name="service">
        <option value="">Select Service</option>
        @foreach($services as $service)
            <option value="{{ $service->name }}" data-price="{{ $service->price }}">{{ $service->name }} - ${{ number_format($service->price, 2) }}</option>
        @endforeach
    </select>
</div>

        <div class="form-group">
            <label for="nurse_attended" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Did a nurse attend?</label>
            <select id="nurse_attended" name="nurse_attended" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>




        <div class="form-group">
            <label for="total_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Price</label>
            <input type="text" id="total_price" name="total_price" readonly class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="0.00">
        </div>

        <div class="form-group">
            <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temperature (°C)</label>
            <input type="number" step="0.1" min="1" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="temperature" name="temperature" required>
        </div>

        <div class="form-group">
            <label for="heart_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Heart Rate (bpm)</label>
            <input type="number"min="1"  class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="heart_rate" name="heart_rate" required>
        </div>

        <div class="form-group">
            <label for="blood_pressure" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Blood Pressure (mmHg)</label>
            <input type="text" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="blood_pressure" name="blood_pressure" required>
        </div>

        <div class="form-group">
            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Consultation</label>
            <textarea class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="reason" name="reason"></textarea>
        </div>

        <div class="form-group">
            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="notes" name="notes"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Add Medical Information</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="medications[]"]');
    const totalPriceField = document.getElementById('total_price');
    const medicationQuantities = document.querySelectorAll('input[name="medication_quantities[]"]');
    const serviceSelect = document.getElementById('service');

    function updateTotalPrice() {
        let totalPrice = 0;

        // Add medications price to total price
        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                const quantity = parseFloat(medicationQuantities[index].value) || 1;
                totalPrice += price * quantity;
            }
        });

        // Add selected service price to total price
        const selectedServiceOption = serviceSelect.options[serviceSelect.selectedIndex];
        if (selectedServiceOption) {
            const servicePrice = parseFloat(selectedServiceOption.getAttribute('data-price')) || 0;
            totalPrice += servicePrice;
        }

        totalPriceField.value = totalPrice.toFixed(2);
    }

    // Update total price when checkboxes are changed
    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                medicationQuantities[index].removeAttribute('disabled');
                medicationQuantities[index].setAttribute('required', 'required');
            } else {
                medicationQuantities[index].setAttribute('disabled', 'disabled');
                medicationQuantities[index].removeAttribute('required');
                medicationQuantities[index].value = '';
            }
            updateTotalPrice();
        });
    });

    // Update total price when quantities are changed
    medicationQuantities.forEach((quantityField, index) => {
        quantityField.addEventListener('input', updateTotalPrice);
    });

    // Update total price when a service is selected
    serviceSelect.addEventListener('change', updateTotalPrice);

    // Initial calculation on page load if there are pre-selected checkboxes
    updateTotalPrice();

    // Handle dynamic patient selection and related medications and appointments
    document.getElementById('patient_id').addEventListener('change', function() {
        const patientId = this.value;
        const appointmentSelect = document.getElementById('appointment_date');
        appointmentSelect.innerHTML = '<option value="">Select Appointment Date</option>'; // Clear current options

        if (patientId) {
            fetch(`/get-appointments/${patientId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(appointment => {
                        const option = document.createElement('option');
                        option.value = appointment.dateTime; // Set the value to the formatted dateTime
                        option.textContent = appointment.dateTime; // Display the formatted dateTime
                        appointmentSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching appointments:', error));
        }

        // Fetch medications based on selected patient
        fetch(`/get-medications/${patientId}`)
            .then(response => response.json())
            .then(data => {
                const medicationsContainer = document.getElementById('medications-checkboxes');
                medicationsContainer.innerHTML = ''; // Clear existing checkboxes
                if (Array.isArray(data)) {
                    data.forEach(medication => {
                        const checkboxContainer = document.createElement('div');
                        checkboxContainer.className = 'flex items-center mb-2';
                        checkboxContainer.innerHTML = `
                            <input type="checkbox" id="medication_${medication.id}" name="medications[]" value="${medication.id}" data-price="${medication.price}" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                            <label for="medication_${medication.id}" class="ml-2 text-gray-700">${medication.name}</label>
                            <input type="number" step="0.01" name="medication_prices[]" value="${medication.price}" readonly class="form-input ml-2 w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <input type="number" name="medication_quantities[]" min="1" max="${medication.quantity}" placeholder="Quantity" disabled class="form-input ml-2 w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        `;
                        medicationsContainer.appendChild(checkboxContainer);
                    });

                    // Reattach event listeners to new checkboxes and quantity fields
                    const newCheckboxes = medicationsContainer.querySelectorAll('input[type="checkbox"][name="medications[]"]');
                    const newQuantities = medicationsContainer.querySelectorAll('input[name="medication_quantities[]"]');

                    newCheckboxes.forEach((checkbox, index) => {
                        checkbox.addEventListener('change', function() {
                            if (checkbox.checked) {
                                newQuantities[index].removeAttribute('disabled');
                                newQuantities[index].setAttribute('required', 'required');
                            } else {
                                newQuantities[index].setAttribute('disabled', 'disabled');
                                newQuantities[index].removeAttribute('required');
                                newQuantities[index].value = '';
                            }
                            updateTotalPrice();
                        });
                    });

                    newQuantities.forEach((quantityField) => {
                        quantityField.addEventListener('input', updateTotalPrice);
                    });

                    // Initial calculation for newly added checkboxes and quantities
                    updateTotalPrice();
                } else {
                    console.error('Invalid data format', data);
                }
            })
            .catch(error => console.error('Error fetching medications:', error));
    });
});
</script>


@endsection
