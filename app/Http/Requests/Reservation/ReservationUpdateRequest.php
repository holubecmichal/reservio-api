<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReservationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_at' => ['nullable', 'filled', 'date', 'required_with:end_at', 'after_or_equal:' . now()->toDateTimeString()],
            'end_at' => ['nullable', 'filled', 'date', 'after:start_at', 'required_with:start_at'],
            'description' => ['nullable', 'string:255'],
        ];
    }
}
