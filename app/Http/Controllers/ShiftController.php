<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{
    
    public function getShift()
    {
        return view('shift.post');
    }
}
