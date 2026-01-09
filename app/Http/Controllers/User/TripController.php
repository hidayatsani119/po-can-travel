<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Trip::with(['bus', 'route'])
            ->where('departure_time', '>', now())
            ->where('status', 'scheduled');

        if ($request->has('departure_city') && $request->departure_city) {
            $query->whereHas('route', function ($q) use ($request) {
                $q->where('departure_city', 'like', '%' . $request->departure_city . '%');
            });
        }

        if ($request->has('arrival_city') && $request->arrival_city) {
            $query->whereHas('route', function ($q) use ($request) {
                $q->where('arrival_city', 'like', '%' . $request->arrival_city . '%');
            });
        }

        if ($request->has('departure_date') && $request->departure_date) {
            $query->whereDate('departure_time', $request->departure_date);
        }

        $trips = $query->paginate(10);

        return view('user.trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        if ($trip->status !== 'scheduled' || $trip->departure_time <= now()) {
            return redirect()->route('trips.index')->with('error', 'Trip tidak tersedia.');
        }

        $bookedSeats = DB::table('bookings')
            ->where('trip_id', $trip->id)
            ->whereIn('status', ['pending', 'awaiting_payment', 'paid', 'confirmed'])
            ->pluck('seat_numbers')
            ->flatten()
            ->toArray();


        $allSeats = range(1, $trip->bus->total_seats);
        $availableSeats = array_diff($allSeats, $bookedSeats);

        return view('user.trips.show', compact('trip', 'availableSeats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
