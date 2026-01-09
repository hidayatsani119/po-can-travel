<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Trip Details -->
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold mb-4">Trip Details</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Route</p>
                                <p class="text-xl font-semibold">
                                    {{ $trip->route->departure_city }} → {{ $trip->route->arrival_city }}
                                </p>
                                <p class="text-gray-600">
                                    {{ $trip->route->departure_terminal }} → {{ $trip->route->arrival_terminal }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Price</p>
                                <p class="text-3xl font-bold text-indigo-600">
                                    Rp {{ number_format($trip->price, 0, ',', '.') }}
                                </p>
                                <p class="text-gray-600">per person</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Departure</p>
                                <p class="text-lg font-medium">
                                    {{ $trip->departure_time->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Arrival</p>
                                <p class="text-lg font-medium">
                                    {{ $trip->arrival_time->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bus Details -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Bus Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Bus Name</p>
                                <p class="text-lg font-medium">{{ $trip->bus->name }}</p>
                                <p class="text-gray-600">Plate: {{ $trip->bus->plate_number }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Bus Type</p>
                                <p class="text-lg font-medium">{{ $trip->bus->type }}</p>
                                <p class="text-gray-600">Capacity: {{ $trip->bus->total_seats }} seats</p>
                            </div>
                        </div>

                        @if($trip->bus->facilities)
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Facilities</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @php
                                        $facilities = is_array($trip->bus->facilities)
                                            ? $trip->bus->facilities
                                            : json_decode($trip->bus->facilities, true);
                                    @endphp
                                    @if(is_array($facilities))
                                        @foreach($facilities as $facility)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                                {{ $facility }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Booking Form</h2>

                        <form method="POST" action="{{ route('user.bookings.store') }}">
                            @csrf
                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="passenger_count" class="block text-sm font-medium text-gray-700 mb-2">
                                        Number of Passengers
                                    </label>
                                    <select name="passenger_count" id="passenger_count" required
                                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            onchange="updateTotalPrice()">
                                        @for($i = 1; $i <= min(10, $trip->available_seats); $i++)
                                            <option value="{{ $i }}">{{ $i }} passenger(s)</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label for="seat_numbers" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Seats (optional)
                                    </label>
                                    <input type="text" name="seat_numbers" id="seat_numbers"
                                           placeholder="Example: 1, 2, 3"
                                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <p class="text-sm text-gray-500 mt-1">
                                        Separate with commas. Leave empty for automatic seat selection.
                                    </p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes (optional)
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>

                            <!-- Available Seats -->
                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-700 mb-2">Available Seats</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($availableSeats as $seat)
                                        <button type="button"
                                                onclick="addSeat({{ $seat }})"
                                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm hover:bg-green-200">
                                            {{ $seat }}
                                        </button>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500 mt-2">
                                    Click a seat to add it to the selected seats list.
                                </p>
                            </div>

                            <!-- Total Price -->
                            <div class="mb-6 p-4 bg-indigo-50 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Price</p>
                                        <p id="totalPrice" class="text-2xl font-bold text-indigo-600">
                                            Rp {{ number_format($trip->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Seats Available</p>
                                        <p class="text-lg font-semibold">{{ $trip->available_seats }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('user.trips.index') }}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Back
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Continue to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotalPrice() {
            const passengerCount = document.getElementById('passenger_count').value;
            const pricePerPerson = {{ $trip->price }};
            const totalPrice = passengerCount * pricePerPerson;

            document.getElementById('totalPrice').textContent =
                'Rp ' + totalPrice.toLocaleString('id-ID');
        }

        function addSeat(seatNumber) {
            const seatInput = document.getElementById('seat_numbers');
            const currentSeats = seatInput.value
                ? seatInput.value.split(',').map(s => s.trim())
                : [];

            if (!currentSeats.includes(seatNumber.toString())) {
                currentSeats.push(seatNumber.toString());
                seatInput.value = currentSeats.join(', ');
            }
        }
    </script>
</x-app-layout>
