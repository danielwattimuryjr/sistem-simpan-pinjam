<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriteriaScore extends Model
{
    protected $fillable = [
        'criteria_name',
        'criteria_category',
        'criteria_weight',
        'batas_bawah',
        'score'
    ];

    public function criteria(): BelongsTo {
        return $this->belongsTo(Criteria::class);
    }
}
