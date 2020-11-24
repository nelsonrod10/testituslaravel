<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimerLoginAttemtsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TimerLoginAttemts Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador se encarga de manejar el tiempo restante luego de 
    | haber intentado login por más de 3 veces
    | 
    |
    */

    public function get()
    {
        return response()->json(session('too-many-attempts'),200);
    }

    public function update()
    {
        $current = (int)session('too-many-attempts');
        $current -= 1;
        session(['too-many-attempts' => $current]);
        return response()->json(session('too-many-attempts'),200);
    }

    public function reset()
    {
        session()->forget('too-many-attempts');
        return;
    }
}
