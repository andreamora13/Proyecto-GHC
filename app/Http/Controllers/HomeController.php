<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=Auth::user()->id;
        $error='Para inicializar datos, Todos los campos deben de ser completados';
        
        $tipocount=App\TipoUsuario::select('id_tipo')->where('id_usuario','=',$user)->count();
        if($tipocount != 0)
        {
            $tipo=App\TipoUsuario::select('id_tipo')->where('id_usuario','=',$user)->get()->last();
        
              if($tipo->id_tipo==1)
              {
                 return view('Admin',compact('error'));
              }
              else{
          
                return view('home');
            }
        }
        else{
            return view('home');
        }
        
    }


   
}
