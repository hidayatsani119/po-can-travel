<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_id' => 'required|exists:trips,id',
            'passenger_count' => 'required|integer|min:1|max:10',
            'seat_numbers' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'trip_id.required' => 'Trip harus dipilih.',
            'trip_id.exists' => 'Trip tidak valid.',
            'passenger_count.required' => 'Jumlah penumpang harus diisi.',
            'passenger_count.integer' => 'Jumlah penumpang harus berupa angka.',
            'passenger_count.min' => 'Minimal 1 penumpang.',
            'passenger_count.max' => 'Maksimal 10 penumpang.',
        ];
    }
}
