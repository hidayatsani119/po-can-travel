<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Payment Proof
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Current Payment Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Current Payment</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'verified' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$payment->status] }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-medium">{{ $payment->payment_method }}</p>
                        </div>

                        @if($payment->proof_path)
                            <div>
                                <p class="text-sm text-gray-500">Current Proof</p>
                                <a href="{{ Storage::url($payment->proof_path) }}" target="_blank"
                                   class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bank Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Destination Bank Account</h3>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-sm text-gray-500">Bank</p>
                                <p class="text-lg font-bold text-gray-900">BCA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Account Number</p>
                                <p class="text-lg font-bold text-gray-900">123 456 7890</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Account Holder</p>
                                <p class="text-lg font-bold text-gray-900">BUS BOOKING SYSTEM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-6">Replace Payment Proof</h3>

                    <form method="POST" action="{{ route('user.payments.update', $payment) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Payment Proof -->
                        <div class="mb-6">
                            <label for="proof" class="block text-sm font-medium text-gray-700 mb-1">
                                New Payment Proof
                            </label>
                            <input type="file" name="proof" id="proof"
                                   class="block w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-indigo-50 file:text-indigo-700
                                   hover:file:bg-indigo-100">
                            <p class="mt-1 text-sm text-gray-500">
                                Upload a new payment proof (JPG, PNG, PDF, max 2MB)
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Leave this empty if you do not want to replace the current proof.
                            </p>
                            @error('proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user.bookings.show', $payment->booking) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md
                               font-semibold text-xs text-gray-700 uppercase tracking-widest
                               hover:bg-gray-50 transition ease-in-out duration-150">
                                Back
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                Update Payment Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
