<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Accident extends Model
{
    protected $fillable = [
        'facility_id',
        'construction_id',
        'notified_users',
        'date'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function construction(): BelongsTo
    {
        return $this->belongsTo(Construction::class);
    }
}
