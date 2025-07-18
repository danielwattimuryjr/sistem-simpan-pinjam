<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanEvaluation extends Model
{
    protected $fillable = [
        'loan_id',
        'nilai_wp',
        'normalized_wp',
        'details',
        'criteria_hash',
        'evaluated_at'
    ];

    protected function casts(): array {
        return [
            'details' => 'array',
        ];
    }

    public function loan() {
        return $this->belongsTo(Loan::class);
    }
}
