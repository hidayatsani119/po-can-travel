<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBookingStatusRequest;
use App\Http\Requests\Admin\UpdatePaymentStatusRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'trip.bus', 'trip.route', 'payment']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by booking code or user
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->latest()->paginate(20);

        $statuses = [
            'pending' => 'Pending',
            'awaiting_payment' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan'
        ];

        return view('admin.bookings.index', compact('bookings', 'statuses'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'trip.bus', 'trip.route', 'payment']);

        $statuses = [
            'pending' => 'Pending',
            'awaiting_payment' => 'Awaiting Payment',
            'paid' => 'Paid',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled'
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected'
        ];

        return view('admin.bookings.show', compact('booking', 'statuses', 'paymentStatuses'));
    }

    public function updateStatus(UpdateBookingStatusRequest $request, Booking $booking)
    {
        $validated = $request->validated();

        $booking->update(['status' => $validated['status']]);

        // Jika status booking menjadi confirmed, update available seats
        if ($validated['status'] === 'confirmed') {
            // Update payment status jika ada
            if ($booking->payment) {
                $booking->payment->update(['status' => 'verified']);
            }
        }

        // Jika booking dibatalkan, kembalikan kursi
        if ($validated['status'] === 'cancelled') {
            $booking->trip->increment('available_seats', $booking->passenger_count);
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui.');
    }

    public function updatePaymentStatus(UpdatePaymentStatusRequest $request, Payment $payment)
    {
        $validated = $request->validated();

        $payment->update([
            'status' => $validated['status'],
            'verified_at' => $validated['status'] === 'verified' ? now() : null,
            'admin_notes' => $validated['admin_notes'] ?? null
        ]);

        // Update booking status based on payment status
        if ($validated['status'] === 'verified') {
            $payment->booking->update(['status' => 'confirmed']);
        } elseif ($validated['status'] === 'rejected') {
            $payment->booking->update(['status' => 'awaiting_payment']);
        }

        return redirect()->route('admin.bookings.show', $payment->booking)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
