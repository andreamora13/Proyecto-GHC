<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App;




class AdmiController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth');
    }
     public function Admin()
    {
        
         
         $error='Todos los campos deben de ser completados';
         

        return view('Admin',compact('error'));
    }


     public function Datos(Request $request)
    {

         $users=App\User::all();
         $partida = App\Partida::all();

         
        
        $this->validate($request, ['alt_mxt'=>'required']);
        $this->validate($request, ['alt_mxp'=>'required']);
        $this->validate($request, ['alt_mxl'=>'required']);
        $this->validate($request, ['agua_ret'=>'required']);
        $this->validate($request, ['agua_rep'=>'required']);
        $this->validate($request, ['agua_rel'=>'required']);
        $this->validate($request, ['ab_ret'=>'required']);
        $this->validate($request, ['ab_rep'=>'required']);
        $this->validate($request, ['ab_rel'=>'required']);
      
        $this->validate($request, ['prodt'=>'required']);
        $this->validate($request, ['prodp'=>'required']);
        $this->validate($request, ['prodl'=>'required']);
        $this->validate($request, ['preciot'=>'required']);
        $this->validate($request, ['preciop'=>'required']);
        $this->validate($request, ['preciol'=>'required']);

         $this->validate($request, ['agua_total'=>'required']);


         if($request->alt_mxt==null or $request->alt_mxp==null or $request->alt_mxl==null or $request->agua_ret==null or $request->agua_rep==null
        or $request->agua_rel==null or $request->ab_ret==null or $request->ab_rep==null or $request->ab_rel==null 
        or $request->prodt==null or $request->prodp==null or $request->prodl==null or $request->preciot==null or $request->preciop==null or $request->preciol==null or $request->agua_total==null)
        {
          $error='Los datos no se han podido guardar, Se deben completar todos los campos';
        }
        else {
	      $error='Datos guardados';
          $partida= new App\Partida;
          $partida->Activa=1;
          $partida->save();
          $id_partida=App\Partida::select('id_partida')->get()->last();
          
        }
        $planta= new App\Planta;
        $planta->tipo_planta='Tomate';
        $planta->alt_max=$request->alt_mxt;
        $planta->agua_re=$request->agua_ret;
        $planta->ab_re=$request->ab_ret;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=$request->prodt;
        $planta->precio=$request->preciot;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $planta= new App\Planta;
        $planta->tipo_planta='Pimenton';
        $planta->alt_max=$request->alt_mxp;
        $planta->agua_re=$request->agua_rep;
        $planta->ab_re=$request->ab_rep;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=$request->prodp;
        $planta->precio=$request->preciop;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $planta= new App\Planta;
        $planta->tipo_planta='Lechuga';
        $planta->alt_max=$request->alt_mxl;
        $planta->agua_re=$request->agua_rel;
        $planta->ab_re=$request->ab_rel;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=$request->prodl;
        $planta->precio=$request->preciol;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $agua= new App\TotalAgua;
        $agua->aguaTotal=$request->agua_total;
        $agua->id_partida=$id_partida->id_partida;
        $agua->save();

        
       

        return view('Admin',compact('error'));
    }



     public function home()
    {

        $user=Auth::user()->id;
        $error='Todos los campos deben de ser completados';



        return view('home');
    }

    public function pruebacheck(Request $request)
    {

         

        return $request->all();
    }

    public function Time()
    {

         

        return view('Timer2');
          

      
    }
    public function Asignacion(Request $request)
    {
        
        $usu=$request->usu;
        $user=$request->input('id');

        $tipousu= new App\TipoUsuario;
        $tipousu->id_usuario=$user;
        $tipousu->id_tipo=$usu;
        $tipousu->save();

        $principal = self::Admin();

        return $principal;
          

      
    }
    public function defecto( )
    {

        $users=App\User::all();
        $partida = App\Partida::all();
        $error='Datos guardados';
        
	    
        $partida= new App\Partida;
        $partida->Activa=1;
        $partida->save();

        $id_partida=App\Partida::select('id_partida')->get()->last();
       
        $planta= new App\Planta;
        $planta->tipo_planta='Tomate';
        $planta->alt_max=80;
        $planta->agua_re=14;
        $planta->ab_re=1.5;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=120;
        $planta->precio=15;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $planta= new App\Planta;
        $planta->tipo_planta='Pimenton';
        $planta->alt_max=60;
        $planta->agua_re=12;
        $planta->ab_re=1.5;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=110;
        $planta->precio=10;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $planta= new App\Planta;
        $planta->tipo_planta='Lechuga';
        $planta->alt_max=40;
        $planta->agua_re=10;
        $planta->ab_re=1.5;
        $planta->tab_ag=0.02;
        $planta->tab_ab=0.08;
        $planta->prod=95;
        $planta->precio=5;
        $planta->inv_acumulado=220;
        $planta->id_partida=$id_partida->id_partida;
        $planta->save();

        $agua= new App\TotalAgua;
        $agua->aguaTotal=4500;
        $agua->id_partida=$id_partida->id_partida;
        $agua->save();

        
       

        return view('Admin',compact('error'));
    }
}
