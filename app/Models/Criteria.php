<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    protected $fillable = [
        'name',
        'category',
        'weight',
        'table_reference',
        'column_reference'
    ];

    public function scores(): HasMany {
        return $this->hasMany(CriteriaScore::class);
    }
}
