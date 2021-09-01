<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Auth;


class GraController extends Controller
{
    public function datos(Request $request)
    {
         $var = $request->input('id');
         $user=Auth::user()->id;
         $partida=App\Partida::select('id_partida')->get()->last();
         $plantas=App\Planta::where('id_partida','=',$partida->id_partida)->get();
         foreach($plantas as $plan)
         {
                   $planta_cultivo[]=$plan->Tipo_planta;
                   $planta_cultivocount[]=App\Cultivo::select('*')->where("id_partida", "=", $partida->id_partida)
                                                           ->where("id_usuario", "=", $user)
                                                           ->where("id_planta", "=", $plan->id_planta)->count();
                   

         }
         $array=array( $planta_cultivo,$planta_cultivocount);
         return $array;
    }

    
    public function vista()
    {
        $var=1;
        return view('Inf',compact('var'));
    }
    public function envio(Request $request)
    {
       

    }
}
