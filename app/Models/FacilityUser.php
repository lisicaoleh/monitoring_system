<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityUser extends Model
{
    protected $table = 'facility_user';
    protected $fillable = ['facility_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
