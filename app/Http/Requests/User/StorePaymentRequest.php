<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'proof.required' => 'Bukti transfer harus diunggah.',
            'proof.file' => 'Bukti transfer harus berupa file.',
            'proof.mimes' => 'Bukti transfer harus berupa JPG, JPEG, PNG, atau PDF.',
            'proof.max' => 'Ukuran bukti transfer maksimal 2MB.',
        ];
    }
}
