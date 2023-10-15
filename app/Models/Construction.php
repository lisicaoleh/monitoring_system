<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Construction extends model
{
    protected $fillable = ['name', 'facility_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
