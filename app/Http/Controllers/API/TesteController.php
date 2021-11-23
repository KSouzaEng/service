<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    function getVal(){
        $var = "Karem";

        if(!$var){
            return response()->json(['error' => 'Não foi possível carregar os clientes registrados'], 400);
        }else{
            return response()->json(['var' => $var], 200);
        }
    }
}
