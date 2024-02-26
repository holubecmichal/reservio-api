<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LogoutAllRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }
}
