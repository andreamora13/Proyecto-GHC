<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Auth;




class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
        $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
        $id_planta=$request->input('id');

        $plantas=App\Planta::where('id_partida','=',$partida->id_partida)->get();
        foreach($plantas as $plan)
        {
               $planta_cultivo[]=$plan->tipo_planta;
               $planta_cultivocount[]=App\Cultivo::select("*")
                                        ->where("id_planta", "=",$plan->id_planta)
                                        ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                        ->count();

               $plainv=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                       
                                       ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                       ->count();
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                 
                                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                                    ->sum('prod_planta');
               }
               
                  $inventariocount=App\Inventario::select('*')
                                                   ->where('id_planta',"=",$plan->id_planta)
                                                   
                                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                                   ->count();
                  if($inventariocount==0)
                  {
                     $inventario[]=0;
                  }
                  else
                  {   $inventario[]=App\Inventario::select('*')
                                                    ->where('id_planta',"=",$plan->id_planta)
                                                    
                                                     ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                                    ->sum('prod_planta');
                  
                  }

              
         }
         $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$partida->id_partida)->count();
         if($mercado_count==0)
         {
              $precio_p[]=0;
              $semana_p[]=0;
         }
         else{
                $mercado=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$partida->id_partida)->get();
                foreach($mercado as $pre)
                {
                     $precio_p[]=$pre->precio;
                     $semana_p[]=$pre->semana;
                }
         }

         $consultaCultivocount = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                     ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();

         if( $consultaCultivocount != 0)
         {
                 $consultaCultivo = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->get();
       
                 foreach($consultaCultivo as $culti)
                 {
                           $id_partidaDet[]=$culti->id_cultivo;
                 }
                 $aguascount = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 ->count();

                 if($aguascount == 0)
                 {
                           $agua[]=0;
                           $semana_ag[]=0;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 }
                 else{
                           $aguas = DB::table ('agua_riegos')
                                     -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                     -> groupBy('semana')
                                     ->whereIn("id_cultivo",$id_partidaDet)
                                     ->orderBy('semana')
                                     -> get();

                           foreach($aguas as $ag)
                           {
                               $agua[]=$ag->total_sales;
                               $semana_ag[]=$ag->semana;
                               $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                               $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
            
                           }
                 }
           
                 $abonoscount = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 ->count();
                 if($abonoscount==0)
                 {
                           $abono[]=0;
                           $semana_ab[]=0;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                 }
                 else{
                           $abonos = DB::table ('abono_cants')
                                     -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                     -> groupBy('semana')
                                     ->whereIn("id_cultivo",$id_partidaDet)
                                     ->orderBy('semana')
                                     -> get();

                           foreach($abonos as $ab)
                           {
                               $abono[]=$ab->total_sal;
                               $semana_ab[]=$ab->semana;
                               $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                               $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                           }
                 }
         }
         else{
                $agua[]=0;
                $semana_ag[]=0;
                $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                $abono[]=0;
                $semana_ab[]=0;
                $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
         }

           
          

        $array=array($planta_cultivo,$planta_cultivocount,$semana_ag,$agua,$planta_inventariocount,$semana_ab,$abono,$agua_Re1,$abono_Re1,$precio_p,$semana_p);
        return  $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
       
        $partida=App\Partida::select('id_partida')->get()->last();
        $plan = App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get()->first();
        $var=$plan->id_planta;
        $plantas=App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();
        $planta=App\Planta::select('*')->where('id_planta','=',$var)->get()->last();
        $tipo_planta=$planta->tipo_planta;
        $usuarios= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->get();
        foreach($usuarios as $item)
        {
           $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $item->id)->where('id_partida', '=',  $partida->id_partida)->get()->last();

           $cultivosdd[]= App\Cultivo::select("*")
                                     ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();
           $cultivosf[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("estado", "=", 1)
                                    ->count();
            $cultivosv[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("cosecha", "=", 1)
                                    ->count();

           $agua[] = App\Cultivo::join("agua_riegos","agua_riegos.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('agua_riego');

           $suma[] = App\Capital::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('capital');
           
                                   
        }
        
         
       
        return  view('InfoInd',compact('var','tipo_planta','usuarios','plantas','cultivosdd','agua','suma','cultivosf','cultivosv'));

    }
    public function vista(Request $request)
    {
        $var=$request->select;
        $partida=App\Partida::select('id_partida')->get()->last();
        $plantas=App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();
        $planta=App\Planta::select('*')->where('id_planta','=',$var)->get()->last();
        $tipo_planta=$planta->tipo_planta;
        $usuarios= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->get();
        foreach($usuarios as $item)
        {
            $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $item->id)->where('id_partida', '=',  $partida->id_partida)->get()->last();
            $cultivosdd[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();
            $cultivosf[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("estado", "=", 1)
                                    ->count();
            $cultivosv[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("cosecha", "=", 1)
                                    ->count();
            $agua[] = App\Cultivo::join("agua_riegos","agua_riegos.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('agua_riego');
            $suma[] = App\Capital::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('capital');
        }
        return view('InfoInd',compact('var','tipo_planta','usuarios','plantas','cultivosdd','agua','suma','cultivosf','cultivosv'));

    }

    

    public function InformeGlo(Request $request)
    {
        $id_partida = $request->input('partida');
        $var2 = $request->input('id_planta');
        $usu= $request->input('id_usuario');
        $user=$request->select;
        $var=$request->eso;
        

        $plantas=App\Planta::select('*')->where('id_partida','=',$id_partida)->get();
        $planta=App\Planta::select('*')->where('id_planta','=',$var)->get()->last();
        $tipo_planta=$planta->tipo_planta;

        $usuarios= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->get();
        foreach($usuarios as $item)
        {
           $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $item->id)->where('id_partida', '=',  $id_partida)->get()->last();
           $cultivosdd[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();
            $cultivosf[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("estado", "=", 1)
                                    ->count();
            $cultivosv[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("cosecha", "=", 1)
                                    ->count();

            $agua[] = App\Cultivo::join("agua_riegos","agua_riegos.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('agua_riego');

            $suma[] = App\Capital::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('capital');
            
        }
        return  view('InformeGlo', compact('tipo_planta','id_partida','user','var','suma','cultivosdd','agua','cultivosf','cultivosv'));

    }
    public function datos(Request $request)
    {
       
        

        $id_planta=$request->input('id');
        $id_partida=$request->input('partida');
        $user= $request->input('user');

        $plantas=App\Planta::where('id_partida','=',$id_partida)->get();

        if($user =="todos")
        {
        
            foreach($plantas as $plan)
            {
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();

                                    
               
              $plainv=App\Inventario::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "inventarios.id_partidausu")
                                    ->select("*")
                                    ->where("inventarios.id_planta", "=", $plan->id_planta)
                                   
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();
                    
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "inventarios.id_partidausu")
                                                    ->select("*")
                                                    ->where("inventarios.id_planta", "=", $plan->id_planta)
                                                   
                                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                                    ->sum('prod_planta');
               }
            }
            $consultaCultivocount = App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();

            if( $consultaCultivocount ==0)
            {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;

            }else
            {
                $consultaCultivo = App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                       }
                }
            }
            
        }else
        {
            foreach($plantas as $plan)
            {
              $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $id_partida)->get()->last();
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::select("*")
                                        ->where("id_planta", "=",$plan->id_planta)
                                        ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                        ->count();

                                    
              $plainv=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                      
                                      ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                      ->count();
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                
                                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                                    ->sum('prod_planta');
               }
            }
            $consultaCultivocount = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                    ->count();
            if( $consultaCultivocount ==0)
            {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;

            }
            else{
                $consultaCultivo = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                       }
                }
            }
            
        }

        
        $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->count();
        if($mercado_count==0)
        {
              $precio_p[]=0;
              $semana_p[]=0;
        }
        else{
                $mercado=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->get();
                foreach($mercado as $pre)
                {
                     $precio_p[]=$pre->precio;
                     $semana_p[]=$pre->semana;
                }
        }

        $array=array($planta_cultivo,$planta_cultivocount,$planta_inventariocount,$precio_p,$semana_p,$agua,$semana_ag,$agua_Re1,$abono,$semana_ab,$abono_Re1);
        return  $array;
    }
    public function Info()
    {
        $partida=App\Partida::select('id_partida')->get()->last();
        $id_partida=$partida->id_partida;
        $user="todos";

        $id_planta=15;
        
        $plantas=App\Planta::where('id_partida','=',$id_partida)->get();

        if($user =="todos")
        {
        
            foreach($plantas as $plan)
            {
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();

                                    
               
              $plainv=App\Inventario::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "inventarios.id_partidausu")
                                    ->select("*")
                                    ->where("inventarios.id_planta", "=", $plan->id_planta)
                                   
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();
                    
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "inventarios.id_partidausu")
                                                    ->select("*")
                                                    ->where("inventarios.id_planta", "=", $plan->id_planta)
                                                   
                                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                                    ->sum('prod_planta');
               }
            }
            $consultaCultivocount = App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->count();

            if( $consultaCultivocount ==0)
            {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;

            }else
            {
                $consultaCultivo = App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.id_planta", "=", $plan->id_planta)
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                       }
                }
            }
            
        }else
        {
            foreach($plantas as $plan)
            {
              $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $id_partida)->get()->last();
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::select("*")
                                        ->where("id_planta", "=",$plan->id_planta)
                                        ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                        ->count();

                                    
              $plainv=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                      
                                      ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                      ->count();
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                
                                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                                    ->sum('prod_planta');
               }
            }
            $consultaCultivocount = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                    ->count();
            if( $consultaCultivocount ==0)
            {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;

            }
            else{
                $consultaCultivo = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=",  $id_partidausu->id_partidausu)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                       }
                }
            }
            
        }

        
        $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->count();
        if($mercado_count==0)
        {
              $precio_p[]=0;
              $semana_p[]=0;
        }
        else{
                $mercado=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->get();
                foreach($mercado as $pre)
                {
                     $precio_p[]=$pre->precio;
                     $semana_p[]=$pre->semana;
                }
        }

        $array=array($planta_cultivo,$planta_cultivocount,$planta_inventariocount,$precio_p,$semana_p,$agua,$semana_ag,$agua_Re1,$abono,$semana_ab,$abono_Re1);
        return  $array;
       }

    public function InformeInd(Request $request)
    {
        $id_partida = $request->input('partida');
        $user=Auth::user()->id;;
        $var=$request->eso;
        $plantas=App\Planta::select('*')->where('id_partida','=',$id_partida)->get();
        $planta=App\Planta::select('*')->where('id_planta','=',$var)->get()->last();
        $tipo_planta=$planta->tipo_planta;
        $usuarios= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$id_partida)
                                    ->get();
        foreach($usuarios as $item)
        {
            $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $item->id)->where('id_partida', '=',  $id_partida)->get()->last();

            $cultivosdd[]= App\Cultivo::select("*")
                                     ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();
            $cultivosf[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("estado", "=", 1)
                                    ->count();
            $cultivosv[]= App\Cultivo::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->where("cosecha", "=", 1)
                                    ->count();
            $agua[] = App\Cultivo::join("agua_riegos","agua_riegos.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('agua_riego');
           $suma[] = App\Capital::select("*")
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->sum('capital');
            
        }
        return   view('InformeInd', compact('tipo_planta','id_partida','user','var','suma','cultivosdd','agua','cultivosv','cultivosf'));

    }
    public function datosInd(Request $request)
    {
       
        
      
        $id_planta=$request->input('id');
        $id_partida=$request->input('partida');
        $user= $request->input('user');
        $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $id_partida)->get()->last();

        $plantas=App\Planta::where('id_partida','=',$id_partida)->get();
        foreach($plantas as $plan)
        {
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::select("*")
                                        ->where("id_planta", "=",$plan->id_planta)
                                        ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                        ->count();
                                     
                                    

              $plainv=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                      ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                      ->count();
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                                    ->sum('prod_planta');
               }
        }
        $consultaCultivocount = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->count();
        if( $consultaCultivocount ==0)
        {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
        }
        else{
                $consultaCultivo = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                

                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re*$consultaCultivocount;
                       }
                }
        }

        $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->count();
        if($mercado_count==0)
        {
              $precio_p[]=0;
              $semana_p[]=0;
        }
        else{
                $mercado=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->get();
                foreach($mercado as $pre)
                {
                     $precio_p[]=$pre->precio;
                     $semana_p[]=$pre->semana;
                }
        }  

        $array=array($planta_cultivo,$planta_cultivocount,$planta_inventariocount,$precio_p,$semana_p,$agua,$semana_ag,$agua_Re1,$abono,$semana_ab,$abono_Re1);
        return  $array;
    }
    public function datd(Request $request)
    {
       
        

        $id_planta=10;
        $id_partida=4;
        $user= 3;

        $plantas=App\Planta::where('id_partida','=',$id_partida)->get();
        foreach($plantas as $plan)
        {
              $planta_cultivo[]=$plan->tipo_planta;
              $planta_cultivocount[]=App\Cultivo::select("*")
                                        ->where("id_planta", "=",$plan->id_planta)
                                        ->where("id_usuario", "=", $user)
                                        ->where("id_partida", "=", $id_partida)
                                        ->count();
                                     
                                    

              $plainv=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                    ->where('id_usuario',"=",$user)
                                                    ->where('id_partida','=',$id_partida)->count();
               if($plainv ==0)
               {
                   $planta_inventariocount[]=0;
               }
               else{
                    $planta_inventariocount[]=App\Inventario::where('id_planta',"=",$plan->id_planta)
                                                    ->where('id_usuario',"=",$user)
                                                    ->where('id_partida','=',$id_partida)->sum('prod_planta');
               }
        }
        $consultaCultivocount = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_usuario", "=", $user)
                                    ->where("id_partida", "=", $id_partida)
                                    ->count();
        if( $consultaCultivocount ==0)
        {
                 $agua[]=0;
                 $semana_ag[]=0;
                 $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                 $agua_Re1[]=$agua_Re->agua_re;
                 $abono[]=0;
                 $semana_ab[]=0;
                 $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                 $abono_Re1[]=$abono_Re->ab_re;
        }
        else{
                $consultaCultivo = App\Cultivo::select("*")
                                    ->where("id_planta", "=",$id_planta)
                                    ->where("id_usuario", "=", $user)
                                    ->where("id_partida", "=", $id_partida)
                                    ->get();
       
                foreach($consultaCultivo as $culti)
                {
                       $id_partidaDet[]=$culti->id_cultivo;
                }
                $aguascount = DB::table ('agua_riegos')
                             -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                

                if($aguascount == 0)
                {
                       $agua[]=0;
                       $semana_ag[]=0;
                       $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->where('id_partida',"=",$id_partida)->get()->last();
                       $agua_Re1[]=$agua_Re->agua_re;
                }
                else{
                       $aguas = DB::table ('agua_riegos')
                                 -> select ('semana' , DB::raw ('SUM(agua_riego) as total_sales'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($aguas as $ag)
                       {
                           $agua[]=$ag->total_sales;
                           $semana_ag[]=$ag->semana;
                           $agua_Re= App\Planta::select('agua_re')->where("id_planta","=",$id_planta)->get()->last();
                           $agua_Re1[]=$agua_Re->agua_re*$consultaCultivocount;
                       }
                } 
                $abonoscount = DB::table ('abono_cants')
                             -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                             -> groupBy('semana')
                             ->whereIn("id_cultivo",$id_partidaDet)
                             ->orderBy('semana')
                             ->count();
                if($abonoscount==0)
                {
                       $abono[]=0;
                       $semana_ab[]=0;
                       $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                       $abono_Re1[]=$abono_Re->ab_re;
                }
                else{
                       $abonos = DB::table ('abono_cants')
                                 -> select ('semana' , DB::raw ('SUM(abono_cant) as total_sal'))
                                 -> groupBy('semana')
                                 ->whereIn("id_cultivo",$id_partidaDet)
                                 ->orderBy('semana')
                                 -> get();

                       foreach($abonos as $ab)
                       {
                           $abono[]=$ab->total_sal;
                           $semana_ab[]=$ab->semana;
                           $abono_Re= App\Planta::select('ab_re')->where("id_planta","=",$id_planta)->get()->last();
                           $abono_Re1[]=$abono_Re->ab_re;
                       }
                }
        }

        $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->count();
        if($mercado_count==0)
        {
              $precio_p[]=0;
              $semana_p[]=0;
        }
        else{
                $mercado=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->where('id_partida',"=",$id_partida)->get();
                foreach($mercado as $pre)
                {
                     $precio_p[]=$pre->precio;
                     $semana_p[]=$pre->semana;
                }
        }  
        

        
        
        return $agua_Re1;
    }
}
