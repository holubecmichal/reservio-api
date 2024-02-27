<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReservationIndexRequest extends FormRequest
{
    /**
     * Sort.
     */
    public const SORT = ['id', '-id', 'start_at', '-start_at', 'end_at', '-end_at'];

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
            'filter' => ['array', 'nullable', 'filled'],
            'filter.lte_start_at' => ['date', 'nullable', 'filled'],
            'filter.gte_start_at' => ['date', 'nullable', 'filled'],
            'filter.lte_end_at' => ['date', 'nullable', 'filled'],
            'filter.gte_end_at' => ['date', 'nullable', 'filled'],
            'per_page' => ['integer', 'nullable', 'filled', 'min:1'],
            'page' => ['integer', 'nullable', 'filled', 'min:1'],
            'sort' => ['array', 'nullable', 'filled'],
            'sort.*' => ['in:' . implode(',', self::SORT)],
        ];
    }
}
