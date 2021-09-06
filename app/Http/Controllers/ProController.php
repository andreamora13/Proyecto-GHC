<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Auth;
use App\Charts\SampleChart;


class ProController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    


   public function principal()
   {
       
       $user=Auth::user()->id;
       $partida=App\Partida::select('id_partida')->get()->last();
       $semanacount=App\Semana::select('*')->where('id_partida', '=',  $partida->id_partida)->count();
       if($semanacount!=0)
       {
            $sema=App\Semana::select('*')->where('id_partida', '=',  $partida->id_partida)->get()->last();
            $semana=$sema->Semana;
       }else{
            $semana=1;
       }
       if($semana < 60)
       {
            $partidacount=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->count();
            if($partidacount !=0)
            {
               $detalle=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get();
               $Total=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->count();

               $partidadet=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get();
               foreach($partidadet as $item)
               {
                 $aguacount[]=App\AguaRiego::select('*')->where('id_partidaDet', '=',  $item->id_partidaDet)->count();
                 if($aguacount !=0)
                 {
                    $aguasum[]=App\AguaRiego::where('id_partidaDet', '=',  $item->id_partidaDet)->get()->sum("agua_riego");
                 }
                 else{
                   $aguasum[]=0;
                 }

                 $abonocount[]=App\AbonoCant::select('*')->where('id_partidaDet', '=',  $item->id_partidaDet)->count();
                 if($abonocount !=0)
                 {
                     $abonosum[]=App\AbonoCant::where('id_partidaDet', '=',  $item->id_partidaDet)->get()->sum("abono_cant");
                 }
                 else{
                  $abonosum[]=0;
                 }
                
                $agua=intval(array_sum($aguasum));
                $abono=intval(array_sum($abonosum));
            
               }
                $visible=1;
            }
         
            else{
                $Total= 0;
                $detalle=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get();
                $agua=0;
                $abono=0;
                $visible=0;
            }
            $AguaTota=App\TotalAgua::select('aguaTotal')->get()->last();
            $AguaTotal=intval($AguaTota->aguaTotal);
            $Semana=0;
            /**/
        

            $usuarios=App\User::where('id', '!=',  $user)->get();
            $inv=App\PartidaDet::where('id_usuario', '!=',  $user)->where('id_partida', '=',  $partida->id_partida)->get();
            $invUser=App\Inventario::where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->where('vendido', '=',  0)->get();
            $plantas=App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();

            foreach($plantas as $item)
            {
              $mercado=App\Mercado::select('*')->where('id_planta','=',$item->id_planta)->where('id_partida','=',$partida->id_partida)->count();
         
              if($mercado == 0)
              {
                 $precio[]=App\Planta::select('*')->where('id_planta','=',$item->id_planta)->where('id_partida','=',$partida->id_partida)->get()->last();
                 $merca[]=App\Planta::select('*')->where('id_planta','=',$item->id_planta)->where('id_partida','=',$partida->id_partida)->get()->last();
              }
              else {
	              $precio[]=App\Mercado::select('*')->where('id_planta','=',$item->id_planta)->where('id_partida','=',$partida->id_partida)->get()->last();
                  $merca[]=App\Mercado::select('*')->where('id_planta','=',$item->id_planta)->where('id_partida','=',$partida->id_partida)->get()->last();
              }
            }

           

            $semana=App\PartidaUsuario::select('*')->where('id_partida', '=',  $partida->id_partida)->count();
        
            return view('Proyecto2',compact('detalle','AguaTotal','Semana','Total','inv','usuarios','invUser','plantas','precio','agua','abono','merca','visible','semana'));
       }
       else
       {
            $var = 1;
            $partida=App\Partida::select('id_partida')->get()->last();
            $plantas=App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();
            $planta=App\Planta::select('*')->where('id_planta','=',$var)->get()->last();
            $tipo_planta=$planta->Tipo_planta;
            $usuarios= App\PartidaUsuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                        ->select("*")
                                        ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                        ->get();
            foreach($usuarios as $item)
            {
               $cultivosdd[]= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("partida_dets.id_usuario", "=", $item->id)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->count();

               $agua[] = App\PartidaDet::join("agua_riegos","agua_riegos.id_partidaDet", "=", "partida_dets.id_partidaDet")
                                        ->select("*")
                                        ->where("partida_dets.id_usuario", "=", $item->id)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->sum('agua_riego');
               foreach($plantas as $plan)
               {

                  $inventariocount=App\Inventario::select('*')->where('id_planta',"=",$plan->id_planta)->where('vendido',"=",1)->where('id_usuario',"=",$item->id)->count();
                  if($inventariocount==0)
                  {
                      $produccion[]=0;
                  
                  }
                  else
                  {   $inventario=App\Inventario::select('*')->where('id_planta',"=",$plan->id_planta)->where('vendido',"=",1)->where('id_usuario',"=",$item->id)->get();
                      foreach( $inventario as $inv)
                      {
                        $inventariosum=App\Inventario::select('*')->where('id_planta',"=",$inv->id_planta)->where('semana',"=",$inv->semana)->sum('prod_planta');
                        $mercado=App\Mercado::select('*')->where('id_planta',"=",$inv->id_planta)->where('semana',"=",$inv->semana)->get()->last();
                        $produccion[]=$inv->prod_planta*$mercado->precio;
                    
                      }
                  }
               }
               $suma[]=array_sum($produccion);                         
            }
            $partidaact = App\Partida::where('id_partida',"=",$partida->id_partida)->update(array('Activa' => 0));
            return view('InfoInd',compact('var','tipo_planta','usuarios','plantas','cultivosdd','agua','suma'));
       }
       
   }

   public function Partida()
   {
        $user= Auth::user()->id;
        $partida=App\Partida::select('id_partida')->where('activa',"=",1)->get()->last();
        $partidacount=App\PartidaUsuario::select('*')->where('id_partida',"=",$partida->id_partida)->where('id_usuario',"=",$user)->count();
        if( $partidacount == 0)
        {
            $partidausu= new App\PartidaUsuario;
            $partidausu->id_partida=$partida->id_partida;
            $partidausu->id_usuario=$user;
            $partidausu->save();
        }
        $partidausuariocount=App\PartidaUsuario::select('*')->where('id_partida',"=",$partida->id_partida)->count();
        if($partidausuariocount<2)
        {
            return view('espera');
        }
        else{

            $principal = self::principal();

            return  $principal;
        }
   }
    
   public function CrearCultivo(Request $request)
   {

       $usuario= Auth::user()->id;
       $partida=App\Partida::select('id_partida')->get()->last();

       $tomate = $request->input('cbox1');
       $pimenton = $request->input('cbox2');
       $lechuga = $request->input('cbox3');
       $rew=$request->all();


       if($tomate=="Tomate")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $tomate)->get()->last();
            $planta=$tomate;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->semana=1;
            $cultivo->tipo_planta=$tomate;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->id_planta= $idplanta->id_planta;
            
            $cultivo->save();
            $partidaDet=self::partidaDet();
            
       }
       if($pimenton=="Pimenton")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $pimenton)->get()->last();
            $planta=$pimenton;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->semana=1;
            $cultivo->tipo_planta=$pimenton;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->id_planta= $idplanta->id_planta;
            $cultivo->save();
            $partidaDet=self::partidaDet();
            
            
       }
       if($lechuga=="Lechuga")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $lechuga)->get()->last();
            $planta=$lechuga;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->semana=1;
            $cultivo->tipo_planta=$lechuga;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->id_planta= $idplanta->id_planta;
            
            $cultivo->save();
            $partidaDet=self::partidaDet();
       }
           
            
       
       $principal = self::principal();
       
       
      return $principal;
   }

   public function partidaDet()
   {
            $usuario= Auth::user()->id;
            $id_Cultivo=App\Cultivo::select("*")
                                    ->get()
                                    ->last();
            $id_Partida=App\Partida::select('id_partida')->get()->last();
            $PartidaDet= new App\PartidaDet;
            $PartidaDet->id_partida=$id_Partida->id_partida;
            $PartidaDet->id_cultivo=$id_Cultivo->id_cultivo;
            $PartidaDet->id_usuario=$usuario;
            $PartidaDet->save();

            $principal = self::principal();
        return $principal;
    
   }
   public function Riego($cult)
   {
        $cult;
        $usuario= Auth::user()->id;
        $partida = DB::table('partidas')->select('id_partida')->get()->last();

        $id_partidaDetcount=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_cultivo", "=",$cult)
                                    ->where("cultivos.cosecha", "=",0)
                                    ->count();
        if( $id_partidaDetcount != 0)
        {
            $id_partidaDet=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_cultivo", "=",$cult)
                                    ->where("cultivos.cosecha", "=",0)
                                    ->get()->last();

            if($id_partidaDet->estado != 1)
            {
                $agua_re = DB::table('plantas')->select('agua_re')->where('id_planta',"=",$id_partidaDet->id_planta)->get()->last();
                $culti=$id_partidaDet->tipo_planta;

                if($culti=='Tomate')
                {
                    
                        $agua_riego=$agua_re->agua_re/3;
                }
                elseif ($culti=='Pimenton')
                {
                    
                       $agua_riego=$agua_re->agua_re/2;
                }
                else {
	                
                       $agua_riego=$agua_re->agua_re/1;
                }
                $AguaTotal = DB::table('total_aguas')->select('aguaTotal')->where('id_partida','=',$partida->id_partida)->get()->last();
                if($AguaTotal->aguaTotal>$agua_riego)
                {
                   $aguat = $AguaTotal->aguaTotal - $agua_riego;
                   $totaldb= new App\TotalAgua;
                   $totaldb->aguaTotal=$aguat;
                   $totaldb->id_partida=$partida->id_partida;
                   $totaldb->save();
         
                }
                else{
                    $agua_riego=0;
                }
                $aguad= new App\AguaRiego;
                $aguad->agua_riego=$agua_riego;
                $aguad->semana=$id_partidaDet->semana;
                $aguad->crecimiento=0;
                $aguad->id_partidaDet=$id_partidaDet->id_partidaDet;
                $aguad->save();
            }
        }
        
        $principal = self::principal();
        return  $principal;
   }
   
    public function Abono($cult)
   {
        $cult;
        $usuario= Auth::user()->id;
        $partida = DB::table('partidas')->select('id_partida')->get()->last();
        $id_partidaDetcount=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_cultivo", "=",$cult)
                                    ->where("cultivos.cosecha", "=",0)
                                    ->count();
        if( $id_partidaDetcount != 0)
        {
            $id_partidaDet=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_cultivo", "=",$cult)
                                    ->where("cultivos.cosecha", "=",0)
                                    ->get()->last();
            if($id_partidaDet->estado != 1)
            {
                    $abono_re = DB::table('plantas')->select('ab_re')->where('id_planta',"=",$id_partidaDet->id_planta)->get()->last();
                    $culti=$id_partidaDet->tipo_planta;

                    if($culti=='Tomate')
                    {
                    
                            $cant_abono=$abono_re->ab_re;
                    }
                    elseif ($culti=='Pimenton')
                    {
                    
                          $cant_abono=$abono_re->ab_re;
                    }
                    else {
	                
                           $cant_abono=$abono_re->ab_re;
                    }

                    $aguad= new App\AbonoCant;
                    $aguad->abono_cant=$cant_abono;
                    $aguad->semana=$id_partidaDet->semana;
                    $aguad->crecimiento=0;
                    $aguad->id_partidaDet=$id_partidaDet->id_partidaDet;
                    $aguad->save();
            }
        }
        
         $principal = self::principal();
        return  $principal;
   }
   public function Crecimiento()
   {
       $perdida=self::perdida();
       $partida=App\Partida::select('id_partida')->get()->last();
       $cultivoscount=  App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("cultivos.cosecha", "=",0)
                                        ->where("cultivos.estado", "=", 0)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->count();
                   
       if( $cultivoscount != 0)
       {
           $cultivos= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("cultivos.cosecha", "=",0)
                                        ->where("cultivos.estado", "=", 0)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->get();
       
           foreach($cultivos as $item)
           {
               $id_partidaDet=App\partidaDet::select('id_partidaDet')->where('id_cultivo', '=',  $item->id_cultivo)->get()->last();
               $semanaTotal= $item->semana;
               $plantabd=App\Planta::select('*')->where('id_planta', '=',  $item->id_planta)->get()->last();
               $agua_re=$plantabd->agua_re;
               $tab_ag=$plantabd->tab_ag;
               $ab_re=$plantabd->ab_re;
               $tab_ab=$plantabd->tab_ab;
               $alt_max=$plantabd->alt_max;
               if($semanaTotal!=1)
               {
                    $aguariego_count=App\AguaRiego::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)
                                                                ->where('crecimiento', '=',  0)->count();
                    if( $aguariego_count != 0)
                    {
                     $agua_riego=App\AguaRiego::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)
                                                            ->where('crecimiento', '=',  0)->get()->sum('agua_riego');
                  
                    }else
                    {
                     $agua_riego=0;
                    }
                    $agua_count=App\Agua::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)->count();
                    if( $agua_count != 0)
                    {
                     $aguab=App\Agua::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)->get()->last();
                     $aguabd=$aguab->agua;
                     $cob_abd=$aguab->cob_a;
                     $absorbd=$aguab->absor;
                     $m_tc_abd=$aguab->m_tc_a;
                    }else
                    {
                       $aguabd=0;
                       $cob_abd=0;
                       $absorbd=0;
                       $m_tc_abd=0;
                    }
                    $cob_a=$agua_riego/$agua_re;
                    $absor=$aguabd*$tab_ag;
                    $agua=$aguabd+$agua_riego-$absor;

                    if($cob_a<=0)
                    {$M_tc_a=0.001;}
                    else if($cob_a>0 and $cob_a<=0.5){
                    $M_tc_a=0.4333;
                    }else if($cob_a >0.5 and $cob_a<1)
                    {$M_tc_a=0.9666;}
                    else if($cob_a==1)
                    {$M_tc_a=1;}
                    else if($cob_a>1 and $cob_a<=2)
                    {$M_tc_a=1;}
                    else if($cob_a>2 and $cob_a<=3)
                    {$M_tc_a=0.0015;}
                    else if($cob_a>3)
                    {$M_tc_a=0.001;}

                    $aguad= new App\Agua;
                    $aguad->agua=$agua;
                    $aguad->cob_a=$cob_a;
                    $aguad->absor=$absor;
                    $aguad->m_tc_a=$M_tc_a;
                    $aguad->semana=$item->semana;
                    $aguad->id_partidaDet=$id_partidaDet->id_partidaDet;
                    $aguad->save();
                    $ag = App\AguaRiego::where('id_partidaDet',"=",$id_partidaDet->id_partidaDet)->update(array('crecimiento' => 1));

                    $abonocant_count=App\AbonoCant::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)->count();
                    if( $abonocant_count != 0)
                    {
                     $abono_cant=App\AbonoCant::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)
                                                            ->where('crecimiento', '=',  0)->get()->sum('abono_cant');
                  
                    }else
                    {
                      $abono_cant=0;
                    }
                    $abono_count=App\Abono::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)->count();
                    if( $abono_count != 0)
                    {
                     $abonob=App\Abono::select('*')->where('id_partidaDet', '=',  $id_partidaDet->id_partidaDet)->get()->last();
                     $abonobd=$abonob->abono;
                     $cabd=$abonob->ca;
                     $ab_absbd=$abonob->ab_abs;
                     $m_tc_abbd=$abonob->m_tc_ab;
                    }else
                    {
                        $abonobd=0;
                        $cabd=0;
                        $ab_absbd=0;
                        $m_tc_abbd=0;
                    }
                    $ca=$abono_cant/$ab_re;
                    $ab_abs=$abonobd*$tab_ab;
                    $abono=$abonobd+$abono_cant-$ab_abs;

                    if($ca<=0)
                    {$M_tc_ab=0.001;}
                    else if($ca>0 and $ca<=0.5){
                    $M_tc_ab=0.4333;
                    }else if($ca >0.5 and $ca<1)
                    {$M_tc_ab=0.9666;}
                    else if($ca==1)
                    {$M_tc_ab=1;}
                    else if($ca>1 and $ca<=2)
                    {$M_tc_ab=0.1056;}
                    else if($ca>2 and $ca<=3)
                    {$M_tc_ab=0.0015;}
                    else if($ca>3)
                    {$M_tc_ab=0.001;}

                    $abonod= new App\Abono;
                    $abonod->abono=$abono;
                    $abonod->ca=$ca;
                    $abonod->ab_abs= $ab_abs;
                    $abonod->m_tc_ab=$M_tc_ab;
                    $abonod->semana=$item->semana;
                    $abonod->id_partidaDet=$id_partidaDet->id_partidaDet;
                    $abonod->save();
                    $ab = App\AbonoCant::where('id_partidaDet',"=",$id_partidaDet->id_partidaDet)->update(array('crecimiento' => 1));

                    $tcm=0.2;
                    $tasa_cre=$tcm*$M_tc_a*$M_tc_ab;
                    $cre_fal=$alt_max-$item->altura;
                    $cre=$tasa_cre*$cre_fal;
                    $altura=$item->altura+$cre;

                    $alt=new App\Altura;
                    $alt->altura=$altura;
                    $alt->tasa_cre=$tasa_cre;
                    $alt->crec=$cre;
                    $alt->cre_fal=$cre_fal;
                    $alt->semana=$item->semana;
                    $alt->id_partidaDet=$id_partidaDet->id_partidaDet;
                    $alt->save();
                   
                    $cult = App\Cultivo::where('id_cultivo', '=', $item->id_cultivo)->update(array('altura' => $altura));
                    
               }
           
            }
       }
       $produccion=self::produccion();
       
        $principal = self::principal();
        return   $principal;
   }
   public function Inventario($cult)
   {
       $cult;
       $partida=App\Partida::select('id_partida')->get()->last();

       $id_partidaDet=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where("cultivos.id_cultivo", "=",$cult)
                                    ->get()->last();
        if($id_partidaDet->estado != 1)
        {
           $produccionbd = DB::table('cultivos')->select('produccion')->where('id_cultivo',"=",$cult)->get()->last();
           $semana= DB::table('cultivos')->select('semana')->where('id_cultivo',"=",$cult)->get()->last();
           $tipo_planta= DB::table('cultivos')->select('id_planta')->where('id_cultivo',"=",$cult)->get()->last();

           $usuario= Auth::user()->id;
           $tipo=$tipo_planta->id_planta;
           $id_partidaDet=App\partidaDet::select('id_partidaDet')->where('id_cultivo', '=',  $cult)->get()->last(); 
       
           $planta = DB::table('inventarios')->select('*')->where('id_planta',"=",$tipo)
                                                          ->where('id_partida',"=",$partida->id_partida)
                                                          ->count();

        
           $prod=$produccionbd->produccion;
           $inv=new App\Inventario;
           $inv->prod_planta=$prod;
           $inv->Semana=$semana->semana;
           $inv->id_planta=$tipo_planta->id_planta;
           $inv->id_usuario=$usuario;
           $inv->id_partida=$partida->id_partida;
           $inv->vendido=0;
           $inv->save();

           $cultivo = App\Cultivo::where('id_cultivo', '=',$cult)->update(array('cosecha' => 1));                  
        }
       $principal = self::principal();
       
       
        
        return  $principal;
   }
   public function Mercado(Request $request)
   {

        $id_planta= $request->input('planta');
        $plantas = DB::table('plantas')->select('*')->where('id_planta', '=',$id_planta)->get();
        $cover_des=4;
        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();

        foreach($plantas as $item )

        {
            
            $Precio_Inibd= DB::table('plantas')->select('precio')->where('id_planta',"=",$item->id_planta)->get()->last();
            $mercado_count= DB::table('mercados')->select('*')->where('id_planta',"=",$item->id_planta)->count();
            $Preciobd= DB::table('mercados')->select('precio')->where('id_planta',"=",$item->id_planta)->get()->last();
            $InvAcumu_bd= DB::table('mercados')->select('inv_acumulado')->where('id_planta',"=",$item->id_planta)->get()->last();
            $alcance_cam_precio= $Precio_Inibd->precio;

            if( $mercado_count==0)

            {
               $Precio=$Precio_Inibd->precio;
               $inv_acum=220;
            }
             else{
                  $Precio= $Preciobd->precio;
                  $inv_acum=$InvAcumu_bd->inv_acumulado;
                  

             }

            if($Precio<=5)
             {
             $demanda=100;
            }else if($Precio>5 and $Precio<=15)
            {
              $demanda=73;
             }
             else if($Precio>15 and $Precio<=20)
            {
               $demanda=45;
             }
             else if($Precio>20 and $Precio<=25)
            {
               $demanda=35;
            }
              else if($Precio>25 and $Precio<=30)
             {
                 $demanda=28;
            }
             else if($Precio>30 and $Precio<=35)
            {
               $demanda=22;
            }
             else if($Precio>35)
             {
            $demanda=15;
            }

            $inv_deseado=$demanda*$cover_des;
            $sum_Prod= DB::table('inventarios')->where('id_planta',"=",$item->id_planta)->where('id_usuario',"=",$user)->where('vendido',"=",0)->where('id_partida','=',$partida->id_partida)->sum('prod_planta');
            $inventario=$inv_acum+$sum_Prod-$demanda;
            $radio_inv=$inv_acum/$inv_deseado;

            if($radio_inv<=0.5)
            {
              $efecto_precio=2;
              }
             else if($radio_inv>0.5 and $radio_inv<=0.7)
             {
              $efecto_precio=1.55;
              }
             else if($radio_inv>0.7 and $radio_inv<1)
             {
              $efecto_precio=1.35;
              }
             else if($radio_inv==1)
             {
              $efecto_precio=1;
              }
             else if($radio_inv>1 and $radio_inv<=1.3)
             {
              $efecto_precio=0.75;
              }
             else if($radio_inv>1.3 and $radio_inv<=1.5)
             {
              $efecto_precio=0.5;
              }
              else
             {
              $efecto_precio=0.3;
              }

             $precio_deseado=$efecto_precio*$Precio;
             $cambio_precio=($precio_deseado-$Precio)/$alcance_cam_precio;
             $New_precio=$Precio+$cambio_precio;

             $mercado=new App\Mercado;
             $mercado->Precio=$New_precio;
             $mercado->ventas=$demanda;
             $mercado->inv_deseado=$inv_deseado;
             $mercado->inv_acumulado= $inventario;
             $mercado->radio_inv= $radio_inv;
             $mercado->efecto_precio=$efecto_precio;
             $mercado->precio_deseado=$precio_deseado;
             $mercado->cambio_precio=$cambio_precio;
             $mercado->Semana=1;
             $mercado->id_planta=$item->id_planta;
             $mercado->id_partida=$partida->id_partida;
             $mercado->save();

             $vendido= App\Inventario::where('id_planta',"=",$item->id_planta)->update(array('vendido' => 1));
        }

        $principal = self::principal();
        return $principal;
        
   }
   public function Seleccion(Request $request)
   {

        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();

          
         $Cultivos=array();
         $Cultivos=$request->all();
         $token = $request->input('_token');
         $regar = $request->input('cbox1');
         $abonar = $request->input('cbox2');
         $cosechar = $request->input('cbox3');

         $tomate = $request->input('tomate');
         $pimenton = $request->input('pimenton');
         $lechuga = $request->input('lechuga');

        $array=array();
        $arrayItem=array();
        $array_unique=array();
        $a=array();
          
         $Cultivos=array();
         $Cultivos=$request->all();
         $token = $request->input('_token');
         $regar = $request->input('cbox1');
         $abonar = $request->input('cbox2');
         $cosechar = $request->input('cbox3');

        foreach( $Cultivos as $item)
        {
             $arrayItem[]=$item;
             foreach($arrayItem as $item2)
             {
                 if($item2 != $token and $item2 !=$regar and $item2 !=$abonar and $item2 !=$cosechar and $item2 !=$tomate and $item2 !=$pimenton and $item2 !=$lechuga)
                 {
                    $array[]= intval( $item);
                 }
             }
        }
        $array_unique=array_unique($array);
         
        foreach($array_unique as $item3)
        {
              $a[]=$item3;
        }
        foreach($a as $item5)
        {
              if($regar=="Regar")
              {
         
                $riego= self::Riego($item5);
              }

              if($abonar=="Abonar")
              {
         
                 $abono= self::Abono($item5);
              }
              if($cosechar=="Cosechar" and $item5!=0)
              {
                  
                 $cosecha= self::Inventario($item5);
              }
        }


        if($tomate=="tomate")
        {
           $cultivo1=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("cultivos.tipo_planta", "=",$tomate)
                                        ->where("partida_dets.id_usuario", "=", $user)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->get();
                    

           foreach($cultivo1 as $item4)
           {
              if($regar=="Regar")
              {
         
                $riego= self::Riego($item4->id_cultivo);
              }

              if($abonar=="Abonar")
              {
         
                  $abono= self::Abono($item4->id_cultivo);
              }
              if($cosechar=="Cosechar" and $item4->id_cultivo!=0)
              {
                  
                 $cosecha= self::Inventario($item4->id_cultivo);
              }
           }

        }
        if($pimenton=="pimenton")
        {
           $cultivo2=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("cultivos.tipo_planta", "=",$pimenton)
                                        ->where("partida_dets.id_usuario", "=", $user)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->get();
                      
           foreach($cultivo2 as $item4)
           {
              if($regar=="Regar")
              {
         
                $riego= self::Riego($item4->id_cultivo);
              }

              if($abonar=="Abonar")
              {
         
                  $abono= self::Abono($item4->id_cultivo);
              }
              if($cosechar=="Cosechar" and $item4->id_cultivo!=0)
              {
                  
                 $cosecha= self::Inventario($item4->id_cultivo);
              }
           }

        }
        if($lechuga=="lechuga")
        {
           $cultivo3=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("cultivos.tipo_planta", "=",$lechuga)
                                        ->where("partida_dets.id_usuario", "=", $user)
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->get();

           foreach($cultivo3 as $item4)
           {
              if($regar=="Regar")
              {
         
                $riego= self::Riego($item4->id_cultivo);
              }

              if($abonar=="Abonar")
              {
         
                  $abono= self::Abono($item4->id_cultivo);
              }
              if($cosechar=="Cosechar" and $item4->id_cultivo!=0)
              {
                  
                 $cosecha= self::Inventario($item4->id_cultivo);
              }
           }

        }
        


         $principal = self::principal();
        return $principal;
   }
   public function  semana()
   {

    
        $partida=App\Partida::select('id_partida')->get()->last();
        $semana=App\Semana::select('*')->count();


        if($semana!=0)
        {
            $sema=App\Semana::select('*')->get()->last();
            $sem=$sema->semana+1;
        }else{
            $sem=1;
        }
           $semanadb= new App\Semana;
           $semanadb->semana=$sem;
           $semanadb->id_partida=$partida->id_partida;
           $semanadb->save();

        $cultivoscount=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->count();
        if($cultivoscount != 0)
        {
            $cultivos=App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                        ->select("*")
                                        ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                        ->get();
            foreach($cultivos as $culti)
            {
               $semana= App\Cultivo::select('semana')->where('id_cultivo',"=",$culti->id_cultivo)->get()->last();
               $act= App\Cultivo::where('id_cultivo',"=",$culti->id_cultivo)->update(array('semana' => $semana->semana+1));
            }
        }
                    

        

          
        $principal=self::Crecimiento();
           

        return  $principal;

   }
   public function perdida()
   {
        $partida=App\Partida::select('id_partida')->get()->last();
        $cultivoscount= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where('cosecha', '=',  0)
                                    ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                    ->count();
        if( $cultivoscount != 0)
        {
             $cultivos= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where('cosecha', '=',  0)
                                    ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                    ->get();

             foreach($cultivos as $cult)
             {
                $aguacount = App\Agua::select("*")->where("id_partidaDet", "=", $cult->id_partidaDet)->count();
               
                if( $aguacount !=0)
                {
                   $agua = App\Agua::select("*")->where("id_partidaDet", "=", $cult->id_partidaDet)->get()->last();
                   
                    if($agua->cob_a ==0 or $agua->cob_a > 1.5 )
                    {
                    $act= App\Cultivo::where('id_cultivo',"=",$cult->id_cultivo)->update(array('estado' => 1));
                    }
                }
                $abonocount = App\Abono::select("*")->where("id_partidaDet", "=", $cult->id_partidaDet)->count();
                if( $abonocount  !=0)
                {
                   $abono = App\Abono::select("*")->where("id_partidaDet", "=", $cult->id_partidaDet)->get()->last();
                   
                    if($abono->ca ==0 or $abono->ca > 1.5 )
                    {
                    $acb= App\Cultivo::where('id_cultivo',"=",$cult->id_cultivo)->update(array('estado' => 1));
                    }
                }
                if( $cult->semana > 24)
                {
                   
                    $acd= App\Cultivo::where('id_cultivo',"=",$cult->id_cultivo)->update(array('estado' => 1));
                    
                }
             }
        }
        $principal=self::principal();
           

        return  $principal;
   }
   public function produccion()
   {
        $partida=App\Partida::select('id_partida')->get()->last();
        $cultivoscount= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where('estado', '=',  0)
                                    ->where('cosecha', '=',  0)
                                    ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                    ->count();
        if( $cultivoscount != 0)
        {
             $cultivos= App\Cultivo::join("partida_dets","partida_dets.id_cultivo", "=", "cultivos.id_cultivo")
                                    ->select("*")
                                    ->where('estado', '=',  0)
                                    ->where('cosecha', '=',  0)
                                    ->where("partida_dets.id_partida", "=", $partida->id_partida)
                                    ->get();

             foreach($cultivos as $cult)
             {
                 $plantabd=App\Planta::select('*')->where('id_planta', '=',  $cult->id_planta)->get()->last();
                 $altmn=$plantabd->alt_max*0.0226;
                 $alturamn=$plantabd->alt_max-$altmn;
                 $altmx=$plantabd->alt_max*0.0115;
                 $alturamx=$plantabd->alt_max-$altmx;

                 if($cult->altura >= $alturamn and $cult->altura < $alturamx)
                 {
                    $prod=$plantabd->prod*0.80;
                   
                 }
                 elseif($cult->altura >=  $alturamx)
                 {
                    $prod=$plantabd->prod;
                 }
                 else
                 {
                     $prod=0;
                 }
                 $ac= App\Cultivo::where('id_cultivo',"=",$cult->id_cultivo)->update(array('produccion' => $prod));
                 
             }
        }
        $principal=self::principal();
           

        return    $principal;
   }
 }


