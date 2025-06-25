<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidWeightSum;

class StoreCriteriaRequest extends FormRequest
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
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'category'              => ['required', 'in:benefit,cost'],
            'weight'                => ['required', 'numeric', new ValidWeightSum],
            'scores'                => ['required', 'array', 'size:5'],
            'scores.*.batas_bawah'  => ['required', 'numeric', 'min:0'],
            'scores.*.skor'         => ['required', 'numeric', 'min:0'],
        ];
    }
}
