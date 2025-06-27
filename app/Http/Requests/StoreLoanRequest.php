<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole('nasabah');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pendapatan'        => ['required', 'numeric', 'min:0'],
            'jumlah_tanggungan' => ['required', 'integer', 'min:0'],
            'jaminan'           => ['required', 'numeric', 'min:0'],
            'jumlah_pinjaman'   => ['required', 'numeric', 'min:100000'],
        ];
    }
}
