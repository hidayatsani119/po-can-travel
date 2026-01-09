<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment for Booking #{{ $booking->booking_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Booking Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Booking Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Route</p>
                            <p class="font-medium">
                                {{ $booking->trip->route->departure_city }} → {{ $booking->trip->route->arrival_city }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Departure Date</p>
                            <p class="font-medium">
                                {{ $booking->trip->departure_time->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Passengers</p>
                            <p class="font-medium">{{ $booking->passenger_count }} passengers</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Payment</p>
                            <p class="text-xl font-bold text-indigo-600">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Bank Account Information</h3>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="text-center mb-6">
                            <h4 class="text-xl font-bold text-blue-800">Transfer to the Account Below</h4>
                            <p class="text-blue-600">Payment Method: Bank Transfer</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-4 rounded-lg border border-blue-100">
                                <p class="text-sm text-gray-500">Bank</p>
                                <p class="text-lg font-bold text-gray-900">BCA</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-blue-100">
                                <p class="text-sm text-gray-500">Account Number</p>
                                <p class="text-lg font-bold text-gray-900">123 456 7890</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-blue-100 md:col-span-2">
                                <p class="text-sm text-gray-500">Account Holder Name</p>
                                <p class="text-lg font-bold text-gray-900">BUS BOOKING SYSTEM</p>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h5 class="font-medium text-yellow-800 mb-2">Important</h5>
                            <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                                <li>
                                    Make sure the transfer amount matches the total payment:
                                    <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong>
                                </li>
                                <li>
                                    Use booking code <strong>{{ $booking->booking_code }}</strong> as the transfer description
                                </li>
                                <li>Please keep your transfer receipt as proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-6">Upload Payment Proof</h3>

                    <form method="POST" action="{{ route('user.payments.store', $booking) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="proof" class="block text-sm font-medium text-gray-700 mb-1">
                                Payment Proof
                            </label>
                            <input type="file" name="proof" id="proof" required
                                   class="block w-full text-sm text-gray-500
                                   file:mr-4 file:py-3 file:px-4 file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-indigo-50 file:text-indigo-700
                                   hover:file:bg-indigo-100">
                            <p class="mt-1 text-sm text-gray-500">
                                Upload payment proof (JPG, PNG, PDF, max 2MB)
                            </p>
                            @error('proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instructions -->
                        <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-medium text-green-800 mb-2">Payment Instructions</h4>
                            <ol class="text-sm text-green-700 list-decimal list-inside space-y-2">
                                <li>Transfer the payment to the bank account above</li>
                                <li>Use booking code <strong>{{ $booking->booking_code }}</strong> as the transfer description</li>
                                <li>Upload the payment proof using the form above</li>
                                <li>Admin will verify the payment within 24 hours</li>
                                <li>The booking status will be updated after verification</li>
                            </ol>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user.bookings.show', $booking) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md
                               font-semibold text-xs text-gray-700 uppercase tracking-widest
                               hover:bg-gray-50 transition ease-in-out duration-150">
                                Back
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                Confirm Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
