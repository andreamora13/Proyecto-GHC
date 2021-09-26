<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- site metas -->
    <title>Partida</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link href="{{asset('css/stylesPrueba.css')}}" rel="stylesheet" text="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Check.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/style.css') }}">
    <!-- fevicon -->
 
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<!-- body -->
    <script src="{{ asset('moon/js/jquery.min.js') }}"></script>
     <script src="{{ asset('moon/js/custom.js') }}"></script>
     <script src="{{ asset('tabla/js/jquery-3.3.1.min.js') }}"></script>
     <script src="{{ asset('tabla/js/main.js') }}"></script>
<!-- body -->
    <script type="text/javascript">
    var inicio=0;
    var timeout=0;
   
    function empezar(elemento)
    {
        
 
            // Obtenemos el valor actual
            inicio=new Date().getTime();
 
            // Guardamos el valor inicial en la base de datos del navegador
            localStorage.setItem("inicio",inicio);
            
            // iniciamos el proceso
            funcionando();
        
    }
    
    function reinicio(elemento)
    {
       
            // detener el cronometro
 
            clearTimeout(timeout);
 
            // Eliminamos el valor inicial guardado
            localStorage.removeItem("inicio");
            timeout=0;
            
            empezar();
        
    }
     function Detener(elemento)
    {
       
            // detener el cronometro
 
            clearTimeout(timeout);
 
            // Eliminamos el valor inicial guardado
            localStorage.removeItem("inicio");
            timeout=0;
           
        
    }
 
 
    function funcionando()
    {
        // obteneos la fecha actual
        var actual = new Date().getTime();
 
        // obtenemos la diferencia entre la fecha actual y la de inicio
        var diff=new Date(actual-inicio);
 
        // mostramos la diferencia entre la fecha actual y la inicial
        var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
        
        var r= diff.getUTCSeconds();
        document.getElementById('cro').innerHTML = r;
        if(r == 59)
        {
           reinicio();
            
           $.ajax({
                             url:'{{ action('ProController@semana')}}',
                             
                                 success: function(data) {
                                    window.location.href = "/principal";
                                    
                                     
                                  },
                                error: function() {
                                    alert('There was some error performing the AJAX call!');
                                 }
                              }
                        );
            
            
        }
        
        // Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
        timeout=setTimeout("funcionando()",1000);
    }
 
    /* Funcion que pone un 0 delante de un valor si es necesario */
    function LeadingZero(Time)
    {
        return (Time < 10) ? "0" + Time : + Time;
    }

 
    window.onload=function()
    {
        if(localStorage.getItem("inicio")!=null)
        {
            // Si al iniciar el navegador, la variable inicio que se guarda
            // en la base de datos del navegador tiene valor, cargamos el valor
            // y iniciamos el proceso.
            inicio=localStorage.getItem("inicio");
           
            funcionando();
        }
    }

    </script>
    <style>
    html, body {
     background-color: #fff;
     font-family: sans-serif;
   
    }
    #circulo{
       height:10px;
       width:10px;
      
       -moz-border-radius:50px;

       -webkit-border-radius:50px;
       border-radius:50px;
    }
  
    </style>
    
</head>
   


@if ($semanacount==0) 
<body class="main-layout" onload="empezar(this);">
@else
<body  class="main-layout"  onload="funcionando();">
@endif


    <!-- loader  -->
   
    <!-- end loader -->
    <!-- header -->
    <header>
                <div class="row" style=" background-color:#052501; color:white">
                  
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 ">

                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                
                                     &nbsp;&nbsp; &nbsp;&nbsp;<a href="/home"><img src="{{ asset('imagenes/logo3.png') }}" style=" width: 70%; height: 70%"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11">
                      
                           <div class="table-responsive" >
                            
                                <table class="tabla" style="width:100%">
                                 <thead>
                                   <tr>
                                    <th><center>Tiempo </center></th>
                                    <th><center>Semana </center></th>
                                    <th scope="col"><center>Agua Total</center></th>
                                    @foreach($plantas as $item)
                                    <th scope="col"><center>Precio {{$item->tipo_planta}}</center></th>
                                    @endforeach()
                                    @foreach($plantas as $item)
                                    <th scope="col"><center>Mercado {{$item->tipo_planta}}</center></th>
                                    @endforeach()
                                    
                                   </tr>
                                 </thead>
                                 <tbody>
         
                                   <tr >
                                   <?php
                                    $user=Auth::user()->id;
                                    $partida=App\Partida::select('id_partida')->get()->last();
                                    $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
                                    $sema=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->count();
                                    if($sema!=0)
                                    {
                                     $sem=App\Semana::select('*')->where('id_partidausu','=',$id_partidausu->id_partidausu)->get()->last();
                                     $s=$sem->semana+1;
                                    }
                                    else
                                    {
                                      $s=1;
                                    }
                                    ?>
             
                                    <td style="border:0"><center><p id='cro' >0 </p></center> </td>
                                    <td style="border:0"><center>{{$s}}</center> </td>
                                    <td style="border:0"><center>{{$aguaTotal}}</td>
                                    <?php
                                    foreach($merca as $it)
                                    {
                                    $precio[]=intval($it->precio);
                                    }
                                    ?>
                                    @foreach($precio as $it)
                                    <td style="border:0"><center>{{$it}}</td>
                                    @endforeach()
                                    
                                    <?php
                                    foreach($merca as $ite)
                                    {
                                    $mercado[]=intval($ite->inv_acumulado);
                                    }
                                    ?>
                                    
                                    @foreach($mercado as $ite)
                                    <td style="border:0">  <center>{{$ite}}</td>
                                    @endforeach() 
                                    
                                   </tr>
                                 </tbody>
                                </table>
                           </div>
                    </div>
                </div>
                
           
          
                <div class="row" style=" background-color:#000; color:white">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="color:white; vertical-align: middle; border: 1px solid white">
                        
                          
                          &nbsp;&nbsp;<p >&nbsp;&nbsp;&nbsp;Usuario:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 90px;background: transparent" value="{{ Auth::user()->name }}">
                          &nbsp;&nbsp;&nbspCultivos:&nbsp;<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 70px;background: transparent;" value="{{$total}}">
                          Agua utilizada:&nbsp;<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 70px;background: transparent;" value="{{$agua}}">
                          Abono utilizado:&nbsp;<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 70px;background: transparent;" value="{{$abono}}">
                          
                          
                                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="color:white; vertical-align: middle; border: 1px solid white">
                        <center>
                        <form action="{{action('ProController@Mercado')}}" method="POST" >
                          @csrf  
                          
                          &nbsp;&nbsp;&nbsp;&nbsp;<p >Inventario:&nbsp;&nbsp;&nbsp;
            
                            <?php
                                 $user=Auth::user()->id;
                                 $partida=App\Partida::select('id_partida')->get()->last();
                                 $planta= App\Planta::select('*')->where('id_partida', '=', $partida->id_partida)->get();
                                 $id_partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('id_partida', '=',  $partida->id_partida)->get()->last();
                            ?>
                          @foreach($planta as $item )

                            <?php
                               
                                 $inv= App\Inventario::where('id_partidausu', '=', $id_partidausu->id_partidausu)
                                                       ->where('vendido', '=', 0)->where('id_planta', '=', $item->id_planta)->get()->sum('prod_planta');
                                
                            ?>
                            <input type="checkbox"  id="{{$item->id_planta}}" name="{{$item->id_planta}}" value="{{$item->id_planta}}"/>&nbsp;
                           {{$item->tipo_planta}}&nbsp;
                                {{$inv}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          @endforeach() 
                        
                         &nbsp;&nbsp; <button type="submit" style="background:#515151; border: white 1px solid; height:30px; width: 70px; font-size:15px; color:white; border-radius:10%">Vender</button>
                        </form>
                        </center>
                    </div>
                </div>
                
      
        <!-- end header inner -->
    </header>
    <!-- end header -->

    <!-- end for_box -->
    <!-- offer -->
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3"  style="background-color:#E3E4E5;border:1px black solid">
            <div class="offer_box" style="width:104%">
                <center>
                    <br>
                    <h6>Selecciona el tipo de planta del cultivo a sembrar</h6>
                    <div class="table-responsive" style=" ">
                        <br>
                        <table class="tabla" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col"><center>Tomate </center></th>
                                    <th scope="col"><center>Pimentón</center></th>
                                    <th scope="col"><center>Lechuga</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border:0">
                                             <div class="incluirtom">
                                                <center><input type="checkbox" id="cbox1" name="cbox1" value="Tomate"/> <label></label>
                                             </div>
                                        </td>
                                        <td style="border:0">
                                             <div class="incluirpi">
                                                <center><input type="checkbox" id="cbox2" name="cbox2" value="Pimenton"/> <label></label>
                                             </div>
                                        </td>
                                        <td style="border:0">
                                             <div class="incluirlec">
                                                <center><input type="checkbox" id="cbox3" name="cbox3" value="Lechuga"/> <label></label>
                                             </div>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                        <br>
                        <button onclick="crea()" style="background-color:#d8fca4; border: black 1px solid; height:30px; width: 70px; font-size:15px; color:black;border-radius:10%">Sembrar</button>
                        <br>    <br>
                </center>
            </div>
            <br><br><br>
            <center>
                <?php
                   $fallidos=App\Cultivo::select('*')->where('id_partidausu', '=', $id_partidausu->id_partidausu)->where('estado','=',1)->count();
                ?>
                <h6 style="color:black">
                    <img src="{{ asset('imagenes/marchita.jpg') }}" style="width: 90px; height: 90px">
                    <br>
                    Fallidos: {{$fallidos}}
                </h6>
           
            </center>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <form class="row" action="{{action('ProController@Seleccion')}} " method="POST">
                @csrf
                         
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8" >
                    <div class="offer_box">
                        <center>
                            
                            <h4>Cultivos
                                
                            </h4>
                            <center>
                                     <input type="checkbox"  id="tomate" name="tomate" value="tomate"/>&nbsp;Tomate&nbsp;&nbsp
                                     <input type="checkbox"  id="pimenton" name="pimenton" value="pimenton"/>&nbsp;Pimenton&nbsp;&nbsp
                                     <input type="checkbox"  id="lechuga" name="lechuga" value="lechuga"/>&nbsp;Lechuga
                            </center>
                                <br>
                            <div class="table-responsive" style="height:30em;  ">
                                    <table class="table" style="width:95% ">
                                        <thead>
                                           <tr>
                                            <th scope="col">
                                                <label class="control control--checkbox">
                                                      <input type="checkbox" class="js-check-all"/>
                                                      <div class="control__indicator"></div>
                                                </label>
                                            </th>
                                            <th scope="col"><center>Planta</th>
                                            <th scope="col"><center>Altura</th>
                                            <th scope="col"><center>Producción</th>
                                            <th scope="col"><center>Semana</th>
                                            <th scope="col"><center>Ilustración</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($detalle as $it)

                                        
       
                                              @if($it->cosecha == 0 and $it->estado==0)
                                                <tr>
                                                <th scope="row" style="width:40px">
                                                    <label class="control control--checkbox">
                                                      <input type="checkbox"  id="{{$it->id_cultivo}}" name="{{$it->id_cultivo}}" value="{{$it->id_cultivo}}"/>
                                                      <div class="control__indicator"></div>
                                                    </label>
                                                </th>
                                                <td ><center>{{$it->tipo_planta}}</td>
                                                <td><center><?php $Altn=number_format($it->altura,2)   ?>{{$Altn}}</td>
                                                <td><center>{{$it->produccion}}</td>
                                                <td><center>{{$it->semana}}</td>
                                                <?php
                                                    $altplanta=App\Planta::select('*')->where('id_partida', '=',  $partida->id_partida )->where('id_planta', '=', $it->id_planta)->get()->last();
                                                    $alt1=$altplanta->alt_max/4;
                                                    $alt2=$alt1*2;
                                                    $alt3=$alt1*3;
                                                    $alt=$altplanta->alt_max;
                                                
                                                ?>
                                                <td><center>
                                                @if($it->estado==0)
                                                   @if($it->tipo_planta=="Tomate")
                                                     @if($it->altura<=$alt1)
                                                         <img src="{{ asset('imagenes/t1.jpeg') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt1 and $it->altura<=$alt2)
                                                         <img src="{{ asset('imagenes/t2.jpeg') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt2 and $it->altura<$alt3)
                                                         <img src="{{ asset('imagenes/t3 .png') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>=$alt3)
                                                         <img src="{{ asset('imagenes/t4.png') }}" style="width: 60px; height: 60px">
                                                     @endif
                                                   @elseif($it->tipo_planta=="Pimenton")
                                                     @if($it->altura<=$alt1)
                                                         <img src="{{ asset('imagenes/p1.jpeg') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt1 and $it->altura<=$alt2)
                                                         <img src="{{ asset('imagenes/p2.jpeg') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt2 and $it->altura<$alt3)
                                                         <img src="{{ asset('imagenes/p3.jgep') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>=$alt3)
                                                         <img src="{{ asset('imagenes/p4.jpeg') }}" style="width: 60px; height: 60px">
                                                     @endif
                                                 
                                                   @elseif($it->tipo_planta=="Lechuga")
                                                     @if($it->altura<=$alt1)
                                                         <img src="{{ asset('imagenes/l1.jpeg') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt1 and $it->altura<=$alt2)
                                                         <img src="{{ asset('imagenes/l2.png') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>$alt2 and $it->altura<$alt3)
                                                         <img src="{{ asset('imagenes/l3.png') }}" style="width: 60px; height: 60px">
                                                         @elseif($it->altura>=$alt3)
                                                         <img src="{{ asset('imagenes/l4.jpeg') }}" style="width: 60px; height: 60px">
                                                     @endif
                                                   @endif
                                                @else
                                                    <img src="{{ asset('imagenes/murio.jpeg') }}" style="width: 60px; height: 60px">
                                                @endif
                                                <?php
                                                    $aguar=App\Agua_riego::select('*')->where('id_cultivo', '=',  $it->id_cultivo)->where('semana', '=', $it->semana)->count();
                                                    $abonoc=App\Abono_cant::select('*')->where('id_cultivo', '=',  $it->id_cultivo)->where('semana', '=', $it->semana)->count();
                                                ?>
                                                  <div style="float:right;width:15px; height:15px;background:#51D1F6;font-size:12px"><center><b>{{$aguar}}</b></div><br>
                                                  <div style="float:right;width:15px; height:15px;background:#a67b5b;font-size:12px"><center><b>{{$abonoc}}</b></div>
                                               
                                                 </td>
                                              @endif
                                            @endforeach() 
                                              </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </center>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4"  style="background-color:#E3E4E5; border:1px black solid">
                    
                    <div class="offer_box" >
                            <br>
                            <center>
                            
                               @if($visible==1)
                                    <br>
                                    <div class="table-responsive" >
                                      
                                       <table class="tabla" style="width:auto">
                                         <thead>
                                           <tr>
              
                                             <th scope="col"><center>Regar </center></th>
                                             <th scope="col"><center>Abonar</center></th>
                                             <th scope="col"><center>Cosechar</center></th>
                                           </tr>
                                         </thead>
                                         <tbody>
         
                                           <tr >
                                             <td style="border:0">
                                                <center>
                                                
                                                <button  id="cbox1" name="cbox1" value="Regar" style="background:transparent" >
                                                    <img src="{{ asset('imagenes/Regar.png') }}" style="width: 55px; height: 55px">
                                                </button>
                                             </td>
                                             <td style="border:0">
                                                <center>
                                                <button  id="cbox2" name="cbox2" value="Abonar" style="background:transparent">
                                                    <img src="{{ asset('imagenes/abonito.png') }}" style="width: 55px; height: 55px">
                                                </button>
                                             </td>
                                             <td style="border:0">
                                                <center>
                                                <button  id="cbox3" name="cbox3" value="Cosechar" style="background:transparent">
                                                    <img src="{{ asset('imagenes/Cosechar2.png') }}" style="width: 60px; height: 55px">
                                                </button>
                                             </td>
                                           </tr>
                                          </tbody>
                                       </table>
                                    </div>
                               @else
                               <br>
                               Empieza a sembrar tus cultivos
                               @endif
                            </center>
                            <br>
                    </div>
                    <div class="offer_box" >
                        <?php
                            $plantas= App\Planta::select('*')->where('id_partida', '=',  $partida->id_partida )->get();
                        ?>
                        <center>
                            <br>
                            <h6>Cultivos Usuarios</h6>
                            <div class="table-responsive" style=" ">
                                   
                                @foreach($usuarios as $item )
                                    <table class="tabla" style="width:100%">
                                        <thead>
                                            <tr>
                                                <center>{{$item->name}}</center>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                @foreach($plantas as $planta) 
                                                <td style="border:0">{{$planta->tipo_planta}}
                                                    <?php
                                                     $id_partidausua=App\Partida_usuario::select('*')->where('id_usuario', '=',  $item->id)->where('id_partida', '=',  $partida->id_partida)->get()->last();
                                                     $cultivos=App\Cultivo::select('*')
                                                                ->where('id_planta', '=',  $planta->id_planta)
                                                                ->where('id_partidausu', '=', $id_partidausua->id_partidausu)
                                                                ->where('cosecha', '=',  0)
                                                                ->where('estado', '=',  0)
                                                                ->count();
                                                    
                                                    ?>
                                                    {{$cultivos}}
                                                </td>
                                                @endforeach()
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach()
                            </div>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>
   
               
     

    <!-- end offer -->
        <script >
           function crea(){
                 if ($('#cbox1').prop('checked') )
                 {
                    var cbox1f="Tomate";
                 }
                 if ($('#cbox2').prop('checked') )
                 {
                    var cbox2f="Pimenton";
                 }
                 if ($('#cbox3').prop('checked') )
                 {
                    var cbox3f="Lechuga";
                 }

                   $.ajax({

                        url:'/cultivo',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: 'POST',
                        data:{
                            cbox1:cbox1f,
                            cbox2:cbox2f,
                            cbox3:cbox3f,
                            _token:$('input[name="_token"]').val()
                        }
                    }).done(function(res){
                        document.body.innerHTML=res;
                    });
             }
        </script>

    <!-- end footer -->
     
    <!-- google map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap"></script>
    <!-- end google map js -->
</body>

</html>
