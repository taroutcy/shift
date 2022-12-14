<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function shift()
    {
        return $this->belongsTo('App\Models\Shift');
    }
    
    public function scheduleStatus()
    {
        return $this->belongsTo('App\Models\ScheduleStatus');
    }
    
    public function workStatus()
    {
        return $this->belongsTo('App\Models\WorkStatus');
    }
    
    protected $fillable = [
        'user_id',
        'shift_id',
        'schedule_status_id',
        'work_status_id', 
        'date'
        ];
    
}
