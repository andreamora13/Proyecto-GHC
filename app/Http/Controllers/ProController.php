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
       $partida=App\Partida::select('*')->get()->last();
       $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
       $semanacount=App\Semana::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->count();
       if($semanacount!=0)
       {
            $sema=App\Semana::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->get()->last();
            $semana=$sema->semana;
       }else{
            $semana=1;
       }
       if($semana < 40 and $partida->activa == 1)
       {
           
            $total=App\Cultivo::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->where('cosecha', '=',  0)->count();
            $total2=App\Cultivo::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->count();
            if($total2 !=0)
            {
               $detalle=App\Cultivo::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->where('cosecha', '=',  0)->get();
               $detalle2=App\Cultivo::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->get();

              
               foreach($detalle2 as $item)
               {
                 $aguacount[]=App\Agua_riego::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->count();
                 if($aguacount !=0)
                 {
                    $aguasum[]=App\Agua_riego::where('id_cultivo', '=',  $item->id_cultivo)->get()->sum("agua_riego");
                 }
                 else{
                   $aguasum[]=0;
                 }

                 $abonocount[]=App\Abono_cant::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->count();
                 if($abonocount !=0)
                 {
                     $abonosum[]=App\Abono_cant::where('id_cultivo', '=',  $item->id_cultivo)->get()->sum("abono_cant");
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
                $total= 0;
                $detalle=App\Cultivo::select('*')->where('id_partidausu', '=',  $id_partidausu->id_partidausu)->get();
                $agua=0;
                $abono=0;
                $visible=0;
            }
            $aguaTota=App\Historico_agua::select('agua_total')->get()->last();
            $aguaTotal=intval($aguaTota->agua_total);
            $semana=0;
            /**/
        

            $usuarios=App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("users.id", '!=',  $user)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->get();

            $invUser=App\Inventario::where('id_partidausu', '=',  $id_partidausu->id_partidausu)->where('vendido', '=',  0)->get();
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

           

            $partusu=App\Partida_usuario::select('*')->where('id_partida', '=',  $partida->id_partida)->count();
        
            return view('Proyecto2',compact('detalle','aguaTotal','semanacount','total','usuarios','invUser','plantas','agua','abono','merca','visible','partusu'));
       
       }
       else
       {    $espera = self::espera();

            return $espera; 
           
       }
            
       
       
   }

   public function Partida()
   {
        $user= Auth::user()->id;
        $partida=App\Partida::select('*')->get()->last();
        
        if($partida->activa == 1)
        {
            $partidacount=App\Partida_usuario::select('*')->where('id_partida',"=",$partida->id_partida)->where('id_usuario',"=",$user)->count();
            if( $partidacount == 0)
            {
                $partidausu= new App\Partida_usuario;
                $partidausu->activa=1;
                $partidausu->id_partida=$partida->id_partida;
                $partidausu->id_usuario=$user;
                $partidausu->save();
            }
            else
            {
              $partidausuario=App\Partida_usuario::select('*')->where('id_partida',"=",$partida->id_partida)->where('id_usuario',"=",$user)->get()->last();
              if($partidausuario->activa==0)
              {
                 $espera = self::espera();
                 return  $espera;
              }
            }
            $partidausuariocount=App\Partida_usuario::select('*')->where('id_partida',"=",$partida->id_partida)->count();
            if($partidausuariocount<2)
                {
                    return view('espera');
                }
                else{

                    $principal = self::principal();

                    return  $principal;
                }
            
        }
        else{
                $principal = self::principal();

                return  $principal;
        }
        
   }
    
   public function CrearCultivo(Request $request)
   {

       $user= Auth::user()->id;
       $partida=App\Partida::select('id_partida')->get()->last();
       $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
       $tomate = $request->input('cbox1');
       $pimenton = $request->input('cbox2');
       $lechuga = $request->input('cbox3');
       if($tomate=="Tomate")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $tomate)->get()->last();
            $planta=$tomate;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->tipo_planta=$tomate;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->semana=1;
            $cultivo->id_planta= $idplanta->id_planta;
            $cultivo->id_partidausu=$id_partidausu->id_partidausu;
            $cultivo->save();
          
            
       }
       if($pimenton=="Pimenton")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $pimenton)->get()->last();
            $planta=$pimenton;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->tipo_planta=$pimenton;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->semana=1;
            $cultivo->id_planta= $idplanta->id_planta;
            $cultivo->id_partidausu=$id_partidausu->id_partidausu;
            $cultivo->save();
           
            
            
       }
       if($lechuga=="Lechuga")
       {
            $idplanta=App\Planta::select('id_planta')->where('tipo_planta', '=',  $lechuga)->get()->last();
            $planta=$lechuga;
            $cultivo= new App\Cultivo;
            $cultivo->altura=0;
            $cultivo->produccion=0;
            $cultivo->tipo_planta=$lechuga;
            $cultivo->cosecha=0;
            $cultivo->estado=0;
            $cultivo->semana=1;
            $cultivo->id_planta= $idplanta->id_planta;
            $cultivo->id_partidausu=$id_partidausu->id_partidausu;
            $cultivo->save();
           
       }
           
        
       
       $principal = self::principal();
       
      return $principal;
   }

  
   public function Riego($cult)
   {
        $cult;
        $user= Auth::user()->id;
        $partida = DB::table('partidas')->select('id_partida')->get()->last();

        $id_partidaDetcount=App\Cultivo::select("*")
                                    ->where("id_cultivo", "=",$cult)
                                    ->where("cosecha", "=",0)
                                    ->where("estado", "=",0)
                                    ->count();
        if( $id_partidaDetcount != 0)
        {
            $id_partidaDet=App\Cultivo::select("*")
                                    ->where("id_cultivo", "=",$cult)
                                    ->where("cosecha", "=",0)
                                    ->where("estado", "=",0)
                                    ->get()->last();

            $agua_re = App\Planta::select('*')->where('id_planta',"=",$id_partidaDet->id_planta)->get()->last();
            $agua_riego =  $agua_re->agua_re/ $agua_re->cant_riegos;
            
            
            $aguaTotal = App\Historico_agua::select('agua_total')->where('id_partida','=',$partida->id_partida)->get()->last();
            if($aguaTotal->agua_total>$agua_riego)
            {
                   $aguat = $aguaTotal->agua_total - $agua_riego;
                   $totaldb= new App\Historico_agua;
                   $totaldb->agua_total=$aguat;
                   $totaldb->id_partida=$partida->id_partida;
                   $totaldb->save();
            }
            else{
                    $agua_riego=0;
            }
            $aguad= new App\Agua_riego;
            $aguad->agua_riego=$agua_riego;
            $aguad->semana=$id_partidaDet->semana;
            $aguad->crecimiento=0;
            $aguad->id_cultivo=$cult;
            $aguad->save();
        }
        
        $principal = self::principal();
        return $principal;
   }
   
    public function Abono($cult)
   {
        $cult;
        $usuario= Auth::user()->id;
        $partida = DB::table('partidas')->select('id_partida')->get()->last();
        $id_partidaDetcount=App\Cultivo::select("*")
                                    ->where("id_cultivo", "=",$cult)
                                    ->where("estado", "=",0)
                                    ->where("cosecha", "=",0)
                                    ->count();
        if( $id_partidaDetcount != 0)
        {
            $id_partidaDet=App\Cultivo::select("*")
                                    ->where("id_cultivo", "=",$cult)
                                    ->where("cosecha", "=",0)
                                    ->where("estado", "=",0)
                                    ->get()->last();
            
            $abono_re = App\Planta::select('*')->where('id_planta',"=",$id_partidaDet->id_planta)->get()->last();
            $cant_abono =  $abono_re->ab_re/ $abono_re->cant_abonos;

            $aguad= new App\Abono_cant;
            $aguad->abono_cant=$cant_abono;
            $aguad->semana=$id_partidaDet->semana;
            $aguad->crecimiento=0;
            $aguad->id_cultivo=$cult;
            $aguad->save();
            
        }
        
         $principal = self::principal();
        return  $principal;
   }
   public function Crecimiento()
   {
        $user=Auth::user()->id;
       $perdida=self::perdida();
       $partida=App\Partida::select('id_partida')->get()->last();
       $id_partidausu=App\Partida_usuario::select('*')->where('id_partida', '=',  $partida->id_partida)->get()->last();

       $cultivocount=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("cultivos.estado", "=", 0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->count();
       if( $cultivocount != 0)
       {
           $cultivos= App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("cultivos.estado", "=", 0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->get();
       
           foreach($cultivos as $item)
           {
              
               $semanaTotal= $item->semana;

               $plantabd=App\Planta::select('*')->where('id_planta', '=',  $item->id_planta)->get()->last();
               $agua_re=$plantabd->agua_re;
               $tab_ag=$plantabd->tab_ag;
               $ab_re=$plantabd->ab_re;
               $tab_ab=$plantabd->tab_ab;
               $alt_max=$plantabd->alt_max;
               $tcm=$plantabd->tasa_cre;

               if($semanaTotal!=1)
               {
                    $aguariego_count=App\Agua_riego::select('*')->where('id_cultivo', '=',  $item->id_cultivo)
                                                                ->where('crecimiento', '=',  0)->count();
                    if( $aguariego_count != 0)
                    {
                     $agua_riego=App\Agua_riego::select('*')->where('id_cultivo', '=',  $item->id_cultivo)
                                                           ->where('crecimiento', '=',  0)->get()->sum('agua_riego');
                  
                    }else
                    {
                     $agua_riego=0;
                    }
                    $agua_count=App\Agua_registro::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->count();
                    if( $agua_count != 0)
                    {
                     $aguab=App\Agua_registro::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->get()->last();
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

                    $aguad= new App\Agua_registro;
                    $aguad->agua=$agua;
                    $aguad->cob_a=$cob_a;
                    $aguad->absor=$absor;
                    $aguad->m_tc_a=$M_tc_a;
                    $aguad->semana=$item->semana;
                   
                    $aguad->id_cultivo=$item->id_cultivo;
                    $aguad->save();

                    $ag = App\Agua_riego::where('id_cultivo', '=',  $item->id_cultivo)->update(array('crecimiento' => 1));

                    $abonocant_count=App\Abono_cant::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->count();
                    if( $abonocant_count != 0)
                    {
                     $abono_cant=App\Abono_cant::select('*')->where('id_cultivo', '=',  $item->id_cultivo)
                                                            ->where('crecimiento', '=',  0)->get()->sum('abono_cant');
                  
                    }else
                    {
                      $abono_cant=0;
                    }
                    $abono_count=App\Abono_registro::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->count();
                    if( $abono_count != 0)
                    {
                     $abonob=App\Abono_registro::select('*')->where('id_cultivo', '=',  $item->id_cultivo)->get()->last();
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

                    $abonod= new App\Abono_registro;
                    $abonod->abono=$abono;
                    $abonod->ca=$ca;
                    $abonod->ab_abs= $ab_abs;
                    $abonod->m_tc_ab=$M_tc_ab;
                    $abonod->semana=$item->semana;
                   
                    $abonod->id_cultivo=$item->id_cultivo;
                    $abonod->save();
                    $ab = App\Abono_cant::where('id_cultivo', '=',  $item->id_cultivo)->update(array('crecimiento' => 1));

                   


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
                
                    $alt->id_cultivo=$item->id_cultivo;
                    $alt->save();
                   
                    $cult = App\Cultivo::where('id_cultivo', '=',  $item->id_cultivo)->update(array('altura' => $altura));
                    
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
       $user= Auth::user()->id;
       $partida=App\Partida::select('id_partida')->get()->last();
       $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
       $sema=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->get()->last();
       $id_partidaDet=App\Cultivo::select("*")
                                  ->where("id_cultivo", "=",$cult)
                                  ->get()->last();
                    
       $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();

       if($id_partidaDet->estado != 1)
       {
           $produccionbd = App\Cultivo::select('produccion')->where('id_cultivo',"=",$cult)->get()->last();
           $semana= App\Cultivo::select('semana')->where('id_cultivo',"=",$cult)->get()->last();
           $tipo_planta= App\Cultivo::select('id_planta')->where('id_cultivo',"=",$cult)->get()->last();

           
           $tipo=$tipo_planta->id_planta;
           $planta = App\Inventario::select('*')->where('id_planta',"=",$tipo)
                                                ->where('id_partidausu',"=",$id_partidausu->id_partidausu)
                                                ->count();

        
           $prod=$produccionbd->produccion;

           $inv=new App\Inventario;
           $inv->prod_planta=$prod;
           $inv->vendido=0;
           $inv->semana=$sema->semana+1;
           $inv->id_planta=$tipo_planta->id_planta;
           $inv->id_partidausu=$id_partidausu->id_partidausu;
           $inv->save();

           $cultivo = App\Cultivo::where('id_cultivo', '=',$cult)->update(array('cosecha' => 1));                  
       }
       $principal = self::principal();
       
       
        
        return  $principal;
   }
   public function Mercado(Request $request)
   {

        $plantasel= $request->all();
        $token = $request->input('_token');
        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
        $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
        $plantas= App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();
        $cover_des=4;
        $sema=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->get()->last();
       
        if( count($plantasel)> 1)
        {
            foreach($plantasel as $item)
            {
                if($item != $token)
                {
                    $id_plantasel[]=$item;
                    
                
                }
            }
            foreach($plantas as $item)
            {
            
                $id_planta= $item->id_planta;
                $vende=in_array ( $id_planta,  $id_plantasel);
                $invcount=App\Inventario::select('*')->where('id_planta','=',$id_planta)->where('vendido','=',0)->where('id_partidausu','=',$id_partidausu->id_partidausu)->count();
            
                if($vende==true)
                {
                    $sum_Prod=App\Inventario::where('id_planta',"=",$id_planta)->where('vendido',"=",0)->where('id_partidausu','=',$id_partidausu->id_partidausu)->sum('prod_planta');
                }
                else
                {
                     $sum_Prod=0;
                }
                $precioplanta=App\Planta::select('*')->where('id_planta',"=",$id_planta)->get()->last();
                $precio_ini=$precioplanta->precio;
                $precio_Inibd=$precio_ini/100;
                $alcance_cam_precio= $precio_Inibd;
                $produ=$precioplanta->prod;
                $mercado_count=App\Mercado::select('*')->where('id_planta',"=",$id_planta)->count();

                if( $mercado_count==0)
                {
                       $precio=$precio_Inibd;
                       $inv_acum=$precioplanta->inv_acumulado;
                }
                else
                {
                  
                     $preciobdini= App\Mercado::select('precio')->where('id_planta',"=",$id_planta)->get()->last();
                     $invAcumu_bd= App\Mercado::select('inv_acumulado')->where('id_planta',"=",$id_planta)->get()->last();
                     $precio= $preciobdini->precio/100;
                     $inv_acum=$invAcumu_bd->inv_acumulado;
                }
                    
                if($precio<=$precio_Inibd-2 )
                {
                        $demanda= $produ+( $produ*0.75);
                }
                else if($precio>$precio_Inibd-2  and $precio<=$precio_Inibd-1 )
                {
                        $demanda=  $produ+( $produ*0.3);
                }
                else if($precio>$precio_Inibd-1  and $precio<=$precio_Inibd)
                {
                        $demanda= $produ;
                }
                else if($precio>$precio_Inibd and $precio<=$precio_Inibd+1)
                {
                        $demanda=  $produ-( $produ*0.4);
                }
                else if($precio>$precio_Inibd+1 and $precio<=$precio_Inibd+2 )
                {
                        $demanda=  $produ -( $produ*0.5);
                }
                else if($precio>$precio_Inibd+2 and $precio<=$precio_Inibd+3)
                {
                        $demanda=  $produ -( $produ*0.6);
                }
                else if($precio>$precio_Inibd+3)
                {
                        $demanda=  $produ -( $produ*0.7);
                }
                $inv_deseado=$demanda*$cover_des;
                $inventarios=$inv_acum+$sum_Prod-$demanda;

                if($inventarios < 0)
                {
                        $inventario= $inv_acum+$sum_Prod;
                }else{
                        $inventario=$inventarios;
                }

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
                      $efecto_precio=1.12;
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

                $precio_deseado=$efecto_precio*$precio;
                $cambio_precio=($precio_deseado-$precio)/$alcance_cam_precio;
                $new_precio=$precio+$cambio_precio;

                $mercado=new App\Mercado;
                $mercado->precio=$new_precio*100;
                $mercado->ventas=$demanda;
                $mercado->inv_deseado=$inv_deseado;
                $mercado->inv_acumulado= $inventario;
                $mercado->radio_inv= $radio_inv;
                $mercado->efecto_precio=$efecto_precio;
                $mercado->precio_deseado=$precio_deseado*100;
                $mercado->cambio_precio=$cambio_precio;
                $mercado->semana=$sema->semana;
                $mercado->id_planta=$id_planta;
                $mercado->id_partida=$partida->id_partida;
                $mercado->save();
               
            }
            foreach($plantasel as $item)
            {
                if($item != $token)
                {
                     $sum_Produ=App\Inventario::where('id_planta',"=",$item)->where('vendido',"=",0)->where('id_partidausu','=',$id_partidausu->id_partidausu)->sum('prod_planta');
                     $preci=App\Mercado::where('id_planta',"=",$item)->get()->last();
                     $cap= $sum_Produ*$preci->precio;

                     $capital=new App\Capital;
                     $capital->capital=$cap;
                     $capital->id_partidausu=$id_partidausu->id_partidausu;
                     $capital->save();

                     $vendido= App\Inventario::where('id_planta',"=",$item)->where('id_partidausu','=',$id_partidausu->id_partidausu)->update(array('vendido' => 1));
                }
            }
            
        }
        
        $principal = self::principal();
        return  $principal;
   }

   public function Seleccion(Request $request)
   {

        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
         $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last(); 
          
        $cultivosselect=array();
        $cultivosselect=$request->all();
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
        $cultivos=array();
          
       

        foreach( $cultivosselect as $item)
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
            if($item3 != 0)
            {
                $cultivos[]=$item3;
            }
        }
        foreach($cultivos as $item5)
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
           $cultivo1= App\Cultivo::select("*")
                                 ->where("tipo_planta", "=",$tomate)
                                  ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
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
           $cultivo2= App\Cultivo::select("*")
                                 ->where("tipo_planta", "=",$pimenton)
                                  ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
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
           $cultivo3= App\Cultivo::select("*")
                                 ->where("tipo_planta", "=",$lechuga)
                                 ->where("id_partidausu", "=", $id_partidausu->id_partidausu)
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


        return  $principal;
   }
   public function  semana()
   {

        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
        $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
        $semana=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->count();
        
        if($semana!=0)
        {
            $sema=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->get()->last();
            $sem=$sema->semana+1;
            
        }else{
            $sem=1;
        }
        if($sem<40)
        {
               $semanadb= new App\Semana;
               $semanadb->semana=$sem;
               $semanadb->id_partidausu=$id_partidausu->id_partidausu;
               $semanadb->save();

               $cultivoscount=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                            ->select("*")
                                            ->where("cultivos.cosecha", "=",0)
                                            ->where("cultivos.estado", "=", 0)
                                            ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                            ->where("partida_usuarios.id_usuario", "=",$user)
                                            ->count();
                       
               if($cultivoscount != 0)
               {
                    $cultivos=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                            ->select("*")
                                            ->where("cultivos.cosecha", "=",0)
                                            ->where("cultivos.estado", "=", 0)
                                            ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                            ->where("partida_usuarios.id_usuario", "=",$user)
                                            ->get();

                    foreach($cultivos as $culti)
                    {
                       $semana= App\Cultivo::select('semana')->where('id_cultivo',"=",$culti->id_cultivo)->get()->last();
                       $act= App\Cultivo::where('id_cultivo',"=",$culti->id_cultivo)->update(array('semana' => $semana->semana+1));
                    }
               }
               $principal=self::Crecimiento();
           

                return $principal;    
        }
        else{
            $partidausu_des = App\Partida_usuario::where('id_partidausu', '=', $id_partidausu->id_partidausu)->update(array('activa' => 0));   

            return 0;
        }
        
         
   }
    

   
   public function perdida()
   {
        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
        $cultivoscount= App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                     ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->count();
                        
                       
        if( $cultivoscount != 0)
        {
             $cultivos=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->get();

             foreach($cultivos as $cult)
             {
                $aguacount = App\Agua_registro::select("*")->where("id_cultivo", "=", $cult->id_cultivo)->count();
               
                if( $aguacount !=0)
                {
                   $agua = App\Agua_registro::select("*")->where("id_cultivo", "=", $cult->id_cultivo)->get()->last();
                   
                    if($agua->cob_a ==0 or $agua->cob_a > 1.5 )
                    {
                    $act= App\Cultivo::where('id_cultivo',"=",$cult->id_cultivo)->update(array('estado' => 1));
                    }
                }
                $abonocount = App\Abono_registro::select("*")->where("id_cultivo", "=", $cult->id_cultivo)->count();
                if( $abonocount  !=0)
                {
                   $abono = App\Abono_registro::select("*")->where("id_cultivo", "=", $cult->id_cultivo)->get()->last();
                   
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
        $user=Auth::user()->id;
        $partida=App\Partida::select('id_partida')->get()->last();
        $cultivocount=App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("cultivos.estado", "=", 0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->count();               
        if( $cultivocount != 0)
        {
             $cultivos= App\Cultivo::join("partida_usuarios","partida_usuarios.id_partidausu", "=", "cultivos.id_partidausu")
                                    ->select("*")
                                    ->where("cultivos.cosecha", "=",0)
                                    ->where("cultivos.estado", "=", 0)
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.id_usuario", "=",$user)
                                    ->get(); 

             foreach($cultivos as $cult)
             {
                 $plantabd=App\Planta::select('*')->where('id_planta', '=',  $cult->id_planta)->get()->last();
                 $altmn=$plantabd->alt_max*0.00652;
                 $alturamn=$plantabd->alt_max-$altmn;
                 $altmx=$plantabd->alt_max*0.001848;
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
   public function info()
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
      
   public function espera()
   {
       
        $partida=App\Partida::select('*')->get()->last();
        $users_partida= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->count();
        $users_fin= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->where("partida_usuarios.activa", "=",0)
                                    ->count();
        
         if($users_partida==$users_fin or $partida->activa==0)
         {
             $partida_des = App\Partida::where('id_partida', '=', $partida->id_partida)->update(array('activa' => 0));
             $info = self::info();

            return $info;
         }
         else{
            

            return  view('espera2');
         }
   }

   public function terminar()
   {
       $partida=App\Partida::select('id_partida')->get()->last();
       $users_partida= App\Partida_usuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->get();
       foreach($users_partida as $item)
       {
          $partidausu_des = App\Partida_usuario::where('id_partidausu', '=', $item->id_partidausu)->update(array('activa' => 0));
       }
       $partida_des = App\Partida::where('id_partida', '=', $partida->id_partida)->update(array('activa' => 0)); $partida_des = App\Partida::where('id_partida', '=', $partida->id_partida)->update(array('activa' => 0));
       $espera = self::espera();

       return $espera;                    
   }

 }


