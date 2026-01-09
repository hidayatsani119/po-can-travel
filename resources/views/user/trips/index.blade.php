<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Search Bus Tickets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">Search Bus Tickets</h1>

                    <form method="GET" action="{{ route('user.trips.index') }}" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="departure_city" class="block text-sm font-medium text-gray-700">
                                    Departure City
                                </label>
                                <input type="text" name="departure_city" id="departure_city"
                                       value="{{ request('departure_city') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="arrival_city" class="block text-sm font-medium text-gray-700">
                                    Destination City
                                </label>
                                <input type="text" name="arrival_city" id="arrival_city"
                                       value="{{ request('arrival_city') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="departure_date" class="block text-sm font-medium text-gray-700">
                                    Departure Date
                                </label>
                                <input type="date" name="departure_date" id="departure_date"
                                       value="{{ request('departure_date') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                        class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search Tickets
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Results -->
                    @if($trips->count() > 0)
                        <div class="space-y-4">
                            @foreach($trips as $trip)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ $trip->route->departure_city }} → {{ $trip->route->arrival_city }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $trip->route->departure_terminal }} → {{ $trip->route->arrival_terminal }}
                                            </p>
                                            <div class="mt-2 flex items-center space-x-4">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-sm">
                                                        {{ $trip->departure_time->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                                                    </svg>
                                                    <span class="text-sm">
                                                        {{ $trip->bus->name }} ({{ $trip->bus->type }})
                                                    </span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="text-sm">
                                                        {{ $trip->available_seats }} seats available
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-indigo-600">
                                                Rp {{ number_format($trip->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-gray-500">per person</p>
                                            <a href="{{ route('user.trips.show', $trip) }}"
                                               class="mt-2 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $trips->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">
                                No tickets available for the selected route.
                            </p>
                            <p class="text-gray-500">
                                Please try adjusting your search filters.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
