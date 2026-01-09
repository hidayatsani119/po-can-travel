<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Booking Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert -->
            @if($booking->status === 'confirmed')
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <div class="flex justify-between items-center">
                        <div>
                            <strong>Booking Confirmed!</strong>
                            <p class="text-sm">Your ticket is ready.</p>
                        </div>
                        <a href="{{ route('user.bookings.download-ticket', $booking) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition">
                            See Your Ticket
                        </a>
                    </div>
                </div>
            @endif

            <!-- Booking Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                Booking #{{ $booking->booking_code }}
                            </h1>
                            <p class="text-gray-600">
                                Created on {{ $booking->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'awaiting_payment' => 'bg-blue-100 text-blue-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$booking->status] }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Trip Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Route</p>
                                <p class="text-xl font-bold">
                                    {{ $booking->trip->route->departure_city }} → {{ $booking->trip->route->arrival_city }}
                                </p>
                                <p class="text-gray-600">
                                    {{ $booking->trip->route->departure_terminal }} → {{ $booking->trip->route->arrival_terminal }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="text-lg font-medium">
                                    {{ $booking->trip->departure_time->format('d/m/Y') }}
                                </p>
                                <p class="text-gray-600">
                                    {{ $booking->trip->departure_time->format('H:i') }}
                                    -
                                    {{ $booking->trip->arrival_time->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Booking Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Passengers</p>
                                <p class="text-2xl font-bold">{{ $booking->passenger_count }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Seats</p>
                                <p class="text-2xl font-bold">
                                    {{ implode(', ', $booking->seat_numbers) }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Total Payment</p>
                                <p class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bus Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Bus Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Bus Name</p>
                                <p class="text-lg font-medium">{{ $booking->trip->bus->name }}</p>
                                <p class="text-gray-600">Plate: {{ $booking->trip->bus->plate_number }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Bus Type</p>
                                <p class="text-lg font-medium">{{ $booking->trip->bus->type }}</p>
                                <p class="text-gray-600">{{ $booking->trip->bus->total_seats }} seats</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Payment</h3>

                        @if($booking->payment)
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <p class="text-sm text-gray-500">Payment Method</p>
                                        <p class="text-lg font-medium">
                                            {{ $booking->payment->payment_method }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status</p>
                                        @php
                                            $paymentStatusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'verified' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $paymentStatusColors[$booking->payment->status] }}">
                                            {{ ucfirst($booking->payment->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if($booking->payment->proof_path)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Payment Proof</p>
                                        <a href="{{ Storage::url($booking->payment->proof_path) }}" target="_blank"
                                           class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                            View Proof
                                        </a>
                                    </div>
                                @endif

                                @if($booking->payment->admin_notes)
                                    <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                        <p class="text-sm text-gray-500 mb-1">Admin Notes</p>
                                        <p class="text-gray-700">{{ $booking->payment->admin_notes }}</p>
                                    </div>
                                @endif

                                @if($booking->payment->status === 'pending')
                                    <div class="mt-6">
                                        <a href="{{ route('user.payments.edit', $booking->payment) }}"
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                            Edit Payment Proof
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @elseif(in_array($booking->status, ['pending', 'awaiting_payment']))
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-blue-900">Booking Awaiting Payment</p>
                                        <p class="text-blue-700 text-sm">
                                            Please complete the payment to confirm your booking.
                                        </p>
                                    </div>
                                    <a href="{{ route('user.payments.create', $booking) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        Pay Now
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 flex justify-between">
                        <a href="{{ route('user.bookings.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                            Back
                        </a>

                        @if(in_array($booking->status, ['pending', 'awaiting_payment']))
                            <form method="POST"
                                  action="{{ route('user.bookings.destroy', $booking) }}"
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
