<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateNasabahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return Auth::check() && Auth::user()->hasRole('admin');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id ?? null;

        return [
            'name'                      => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'nomor_induk_kependudukan'  => ['required', 'numeric', 'digits_between:10,20', Rule::unique('user_profiles', 'nomor_induk_kependudukan')->ignore($userId, 'user_id')],
            'nomor_rekening'            => ['required', 'numeric', 'digits_between:5,25', Rule::unique('user_profiles', 'nomor_rekening')->ignore($userId, 'user_id')],
            'jenis_kelamin'             => ['required', 'in:l,p'],
            'alamat'                    => ['required', 'string'],
            'kecamatan'                 => ['required', 'string'],
            'kabupaten'                 => ['required', 'string'],
            'provinsi'                  => ['required', 'string'],
        ];
    }
}
