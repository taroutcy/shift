<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkStatus extends Model
{
    public function schedule()
    {
        return $this->hasOne('App\Models\Schedule');
    }
}
