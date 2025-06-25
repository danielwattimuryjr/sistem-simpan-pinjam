<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'pendapatan',
        'jumlah_tanggungan',
        'jaminan',
        'jumlah_pinjaman',
        'status'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function evaluation() {
        return $this->hasOne(LoanEvaluation::class);
    }
}
