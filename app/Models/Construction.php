<?php

namespace App\Models;

class Construction
{
    protected $fillable = ['name', 'facility_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
