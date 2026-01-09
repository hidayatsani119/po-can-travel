<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePaymentRequest;
use App\Http\Requests\User\UpdatePaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if booking can be paid
        if (!in_array($booking->status, ['pending', 'awaiting_payment'])) {
            return redirect()->route('user.bookings.show', $booking)
                ->with('error', 'Booking tidak dapat dibayar.');
        }

        // Check if payment already exists
        if ($booking->payment) {
            return redirect()->route('user.payments.edit', $booking->payment);
        }

        return view('user.payments.create', compact('booking'));
    }

    public function store(StorePaymentRequest $request, Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if booking can be paid
        if (!in_array($booking->status, ['pending', 'awaiting_payment'])) {
            return redirect()->route('user.bookings.show', $booking)
                ->with('error', 'Booking tidak dapat dibayar.');
        }

        // Check if payment already exists
        if ($booking->payment) {
            return redirect()->route('user.payments.edit', $booking->payment);
        }

        $validated = $request->validated();

        // Handle proof upload
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payments/proofs', 'public');
        }

        // Create payment - using default bank transfer method
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => 'bank_transfer', // Default method
            'amount' => $booking->total_amount,
            'proof_path' => $proofPath,
            'bank_name' => 'BCA', // Hard coded
            'account_number' => '1234567890', // Hard coded
            'account_name' => 'BUS BOOKING SYSTEM', // Hard coded
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        // Update booking status
        $booking->update(['status' => 'awaiting_payment']);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    public function edit(Payment $payment)
    {
        // Authorization check
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if payment can be edited
        if ($payment->status !== 'pending') {
            return redirect()->route('user.bookings.show', $payment->booking)
                ->with('error', 'Pembayaran sudah diverifikasi, tidak dapat diubah.');
        }

        return view('user.payments.edit', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        // Authorization check
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if payment can be edited
        if ($payment->status !== 'pending') {
            return redirect()->route('user.bookings.show', $payment->booking)
                ->with('error', 'Pembayaran sudah diverifikasi, tidak dapat diubah.');
        }

        $validated = $request->validated();

        // Handle proof upload
        if ($request->hasFile('proof')) {
            // Delete old proof if exists
            if ($payment->proof_path && Storage::disk('public')->exists($payment->proof_path)) {
                Storage::disk('public')->delete($payment->proof_path);
            }

            $proofPath = $request->file('proof')->store('payments/proofs', 'public');
            $payment->proof_path = $proofPath;
        }

        // Update payment
        $payment->update(['paid_at' => now()]);

        return redirect()->route('user.bookings.show', $payment->booking)
            ->with('success', 'Bukti pembayaran berhasil diperbarui.');
    }
}
