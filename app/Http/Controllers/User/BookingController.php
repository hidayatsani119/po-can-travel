<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['trip.bus', 'trip.route', 'payment'])
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        $trip = Trip::findOrFail($validated['trip_id']);

        // Validate available seats
        if ($trip->available_seats < $validated['passenger_count']) {
            return redirect()->back()
                ->with('error', 'Kursi tidak tersedia.')
                ->withInput();
        }

        // Process seat numbers
        $seatNumbers = [];
        if (!empty($validated['seat_numbers'])) {
            // Convert string "1, 2, 3" to array [1, 2, 3]
            $seatNumbers = array_map('intval',
                array_map('trim', explode(',', $validated['seat_numbers']))
            );

            // Validate seat numbers are within range
            foreach ($seatNumbers as $seat) {
                if ($seat < 1 || $seat > $trip->bus->total_seats) {
                    return redirect()->back()
                        ->with('error', 'Nomor kursi tidak valid.')
                        ->withInput();
                }
            }

            // Check if seats are available
            $bookedSeats = [];
            foreach ($trip->bookings()->whereNotIn('status', ['cancelled'])->get() as $booking) {
                $bookedSeats = array_merge($bookedSeats, $booking->seat_numbers);
            }

            $unavailableSeats = array_intersect($seatNumbers, $bookedSeats);
            if (!empty($unavailableSeats)) {
                return redirect()->back()
                    ->with('error', 'Kursi ' . implode(', ', $unavailableSeats) . ' sudah dipesan.')
                    ->withInput();
            }
        } else {
            // Auto assign seats if not specified
            $allSeats = range(1, $trip->bus->total_seats);
            $bookedSeats = [];
            foreach ($trip->bookings()->whereNotIn('status', ['cancelled'])->get() as $booking) {
                $bookedSeats = array_merge($bookedSeats, $booking->seat_numbers);
            }
            $availableSeats = array_diff($allSeats, $bookedSeats);

            if (count($availableSeats) < $validated['passenger_count']) {
                return redirect()->back()
                    ->with('error', 'Kursi tidak mencukupi.')
                    ->withInput();
            }

            $seatNumbers = array_slice(array_values($availableSeats), 0, $validated['passenger_count']);
        }

        // Calculate total amount
        $totalAmount = $trip->price * $validated['passenger_count'];

        // Create booking
        $booking = Booking::create([
            'booking_code' => Booking::generateBookingCode(),
            'user_id' => Auth::id(),
            'trip_id' => $validated['trip_id'],
            'seat_numbers' => $seatNumbers,
            'passenger_count' => $validated['passenger_count'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update available seats
        $trip->decrement('available_seats', $validated['passenger_count']);

        // Redirect to payment page
        return redirect()->route('user.payments.create', $booking)
            ->with('success', 'Booking berhasil dibuat! Silakan lanjutkan pembayaran.');
    }

    public function show(Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['trip.bus', 'trip.route', 'payment']);

        return view('user.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if not already paid/confirmed
        if (!in_array($booking->status, ['pending', 'awaiting_payment'])) {
            return redirect()->back()
                ->with('error', 'Booking tidak dapat dibatalkan.');
        }

        // Return seats
        $booking->trip->increment('available_seats', $booking->passenger_count);

        // Update status
        $booking->update(['status' => 'cancelled']);

        // Cancel payment if exists
        if ($booking->payment) {
            $booking->payment->update(['status' => 'rejected']);
        }

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    public function downloadTicket(Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow download if booking is confirmed
        if ($booking->status !== 'confirmed') {
            return redirect()->back()
                ->with('error', 'Tiket hanya bisa diunduh setelah booking dikonfirmasi.');
        }

        $booking->load(['trip.bus', 'trip.route', 'user']);

        return view('user.bookings.ticket', compact('booking'));
    }
}
