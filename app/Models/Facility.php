<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function constructions(): HasMany
    {
        return $this->hasMany(Construction::class);
    }

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'facility_user', 'facility_id', 'user_id');
    }
}
