<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket - {{ $booking->booking_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=person" />
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto my-8 p-8 bg-white rounded-lg shadow-lg">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">BUS TICKET</h1>
            <p class="text-gray-600">
                Booking Code: <span class="font-bold">{{ $booking->booking_code }}</span>
            </p>
        </div>

        <!-- Ticket Details -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Route -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">ROUTE</h2>
                    <div class="flex items-center">
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ $booking->trip->route->departure_city }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->trip->route->departure_terminal }}</p>
                        </div>
                        <div class="mx-4">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ $booking->trip->route->arrival_city }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->trip->route->arrival_terminal }}</p>
                        </div>
                    </div>
                </div>

                <!-- Date & Time -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">SCHEDULE</h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-600">Departure</p>
                            <p class="text-lg font-bold">
                                {{ $booking->trip->departure_time->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Arrival</p>
                            <p class="text-lg font-bold">
                                {{ $booking->trip->arrival_time->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Passenger & Bus Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Passenger Details -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">PASSENGER DETAILS</h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="text-lg font-bold">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Number of Passengers</p>
                            <p class="text-lg font-bold">{{ $booking->passenger_count }} passengers</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Seat Number(s)</p>
                            <p class="text-lg font-bold">{{ implode(', ', $booking->seat_numbers) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bus Details -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">BUS DETAILS</h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-600">Bus Name</p>
                            <p class="text-lg font-bold">{{ $booking->trip->bus->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">License Plate</p>
                            <p class="text-lg font-bold">{{ $booking->trip->bus->plate_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Bus Type</p>
                            <p class="text-lg font-bold">{{ $booking->trip->bus->type }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Important Information -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h3 class="font-bold text-yellow-800 mb-2">IMPORTANT INFORMATION:</h3>
            <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                <li>Please show this ticket during terminal check-in</li>
                <li>Check-in at least 30 minutes before departure</li>
                <li>Bring a valid ID matching the name on the ticket</li>
                <li>This ticket is valid for {{ $booking->passenger_count }} passenger(s)</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600 text-sm">
            <p>Printed on: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Status: <span class="font-bold text-green-600">CONFIRMED</span></p>
        </div>
    </div>
</body>
</html>
