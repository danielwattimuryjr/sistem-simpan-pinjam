<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'nomor_induk_kependudukan',
        'nomor_rekening',
        'jenis_kelamin',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
