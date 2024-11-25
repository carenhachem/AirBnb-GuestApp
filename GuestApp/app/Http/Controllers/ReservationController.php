<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\accomodation;

class ReservationController extends Controller
{
    //joe will call /api/reservation{id} the id will be accomodations.accomodationid
    
    public function reserve(accomodation $accomodation, Request $request)
    {
       

      
        return; 
    }
}
