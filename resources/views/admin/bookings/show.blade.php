<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Booking Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Booking Information -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Booking Information</h2>
                            <p class="text-gray-600">Booking Code: {{ $booking->booking_code }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Customer</p>
                                    <p class="font-medium">{{ $booking->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Booking Date</p>
                                    <p class="font-medium">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Passengers</p>
                                    <p class="font-medium">{{ $booking->passenger_count }} person(s)</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Seat Numbers</p>
                                    <p class="font-medium">{{ implode(', ', $booking->seat_numbers) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Amount</p>
                                    <p class="font-medium text-lg text-indigo-600">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Notes</p>
                                    <p class="font-medium">{{ $booking->notes ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Information -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Trip Information</h2>
                        </div>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Route</p>
                                    <p class="font-medium">{{ $booking->trip->route->departure_city }} → {{ $booking->trip->route->arrival_city }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Terminals</p>
                                    <p class="font-medium">{{ $booking->trip->route->departure_terminal }} → {{ $booking->trip->route->arrival_terminal }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Departure</p>
                                    <p class="font-medium">{{ $booking->trip->departure_time->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Arrival</p>
                                    <p class="font-medium">{{ $booking->trip->arrival_time->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Bus</p>
                                    <p class="font-medium">{{ $booking->trip->bus->name }} ({{ $booking->trip->bus->plate_number }})</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Bus Type</p>
                                    <p class="font-medium">{{ $booking->trip->bus->type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Actions & Payment -->
                <div class="space-y-6">
                    <!-- Update Status -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Update Status</h2>
                        </div>
                        <div class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Booking Status</label>
                                    <select name="status" id="status" required
                                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" {{ $booking->status == $key ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    @if($booking->payment)
                        <div class="bg-white rounded-lg shadow">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">Payment Information</h2>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Payment Method</p>
                                        <p class="font-medium">{{ $booking->payment->payment_method }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Amount</p>
                                        <p class="font-medium">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status</p>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $booking->payment->status == 'verified' ? 'bg-green-100 text-green-800' :
                                           ($booking->payment->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($booking->payment->status) }}
                                    </span>
                                    </div>

                                    @if($booking->payment->proof_path)
                                        <div>
                                            <p class="text-sm text-gray-500 mb-2">Proof of Payment</p>
                                            <a href="{{ Storage::url($booking->payment->proof_path) }}" target="_blank"
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Proof
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Update Payment Status -->
                                    <div class="pt-4 border-t">
                                        <form method="POST" action="{{ route('admin.bookings.update-payment-status', $booking->payment) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                                                <select name="status" id="payment_status" required
                                                        class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                                    @foreach($paymentStatuses as $key => $status)
                                                        <option value="{{ $key }}" {{ $booking->payment->status == $key ? 'selected' : '' }}>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                                                <textarea name="admin_notes" id="admin_notes" rows="3"
                                                          class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $booking->payment->admin_notes ?? '' }}</textarea>
                                            </div>

                                            <button type="submit"
                                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Update Payment Status
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
