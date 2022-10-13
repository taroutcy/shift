<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    public function __construct()
    {
    }
    
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
    
}
