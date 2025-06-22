<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Criteria;

class ValidWeightSum implements ValidationRule
{
    protected $exceptId;

    public function __construct($exceptId = null)
    {
        $this->exceptId = $exceptId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Criteria::query();

        if ($this->exceptId) {
            $query->where('id', '!=', $this->exceptId);
        }

        $existingTotal = $query->sum('weight');
        $newTotal = $existingTotal + floatval($value);

        if ($newTotal > 1.0) {
            $fail("Total bobot kriteria tidak boleh lebih dari 1.00. Saat ini sudah: " . number_format($existingTotal, 2));
        }
    }
}
