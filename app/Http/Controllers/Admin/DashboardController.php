<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_trips' => Trip::count(),
            'active_trips' => Trip::where('status', 'scheduled')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
        ];

        $recentBookings = Booking::with(['user', 'trip.bus', 'trip.route'])
            ->latest()
            ->take(10)
            ->get();

        $recentPayments = Payment::with(['booking.user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentPayments'));
    }
}
