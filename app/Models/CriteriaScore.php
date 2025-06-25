<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriteriaScore extends Model
{
    protected $fillable = [
        'batas_bawah',
        'score'
    ];

    public function criteria(): BelongsTo {
        return $this->belongsTo(Criteria::class);
    }
}
