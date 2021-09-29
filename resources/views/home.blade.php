


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Inicio</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
   
      <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/bootstrap.min.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/style.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/responsive.css') }}">
           <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/bootstrap.min.css') }}">
    <!-- Style -->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/style.css') }}">
       
    <!-- style css -->

    <!-- Responsive-->
    <script>
        function mostrar(id, id2)
        {
            var objeto=document.getElementById(id);
            var objeto2=document.getElementById(id2);
            
            if(objeto.style.display=="block")
                objeto.style.display="none";
            else
                objeto.style.display="block";
                objeto2.style.display="none";
                
        }
        function salir(){
            document.getElementById('logout-form').submit();
    
        }
        //Función para actualizar cada 20 segundos(20000 milisegundos)
   
        setInterval("salir()",180000);
    </script>

    <style>


        .oculto {
        display:none;
       

            }
        .not-active { 
            pointer-events: none; 
            cursor: default; 
        } 
    </style>


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout "  style="  background-image: linear-gradient(to right,#006341, #a7f25e)">
    <!-- loader  -->
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Inicio
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Ingreso</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registro</a>
                                </li>
                            @endif
                 </div>
                 <div class="container">
                        @else

                                <a class="navbar-brand" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            
                        @endguest
                    </ul>
               </div>
            </div>
  </nav>
    <!-- end loader -->
    <!-- header -->
    <header>
        <!-- header inner -->
        <div class="header">

            <div class="container">
                <div class="row" >
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col logo_section">
                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                    <a href="/"> <img src="{{ asset('imagenes/logo6.png') }}" style=" width: 30%; height: 30%"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                       <div class="location_icon_bottum_tt">
                            <h1 style=" color: white; font-family:Freestyle Script; font-size:70px" translate="no">Greenhouse Crops</h1>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
        <!-- end header inner -->
    </header>
<div id="about" class="about">
        <div class="container"  >
            <div class="row" >

                <div class="col-xl-5 col-lg-5 col-md-5 co-sm-l2">
                    <div class="about_box">
                       <br>
                        <?php
                        $partcount=App\Partida::select('*')->count();
                        if($partcount != 0)
                        {
                            $part=App\Partida::select('*')->get()->last();
                            $parti=$part->activa;
                        }
                        else
                        {
                            $parti=0;
                        }
                        
                         
                       
                       ?>
                     
                       @if($parti==1)
                           <?php
                           $user= Auth::user()->id;
                           $partida=App\Partida::select('*')->get()->last();
                           $partidausu=App\Partida_usuario::select('*')->where('id_partida', '=',  $partida->id_partida)->where('id_usuario', '!=',  $user)->count();
                           ?>
                               @if($partidausu>$partida->max_usuarios)
                               <a href="{{ action('ProController@Partida') }}" class="not-active" >

                                   <h5 style="color:white; height:20px">Iniciar</h5>
                                </a>
                                <p style="color:white"> &nbsp &nbsp   Partida con jugadores completos
                                @else
                                <a href="{{ action('ProController@Partida') }}">

                                   <h5 style="color:white; height:20px">Iniciar</h5>
                                </a>
                                @endif()
                       @else
                             <p style="color:white"> &nbsp Espera a que el admin inicie la partida
                            
                        @endif()
                        <br><br>
                       <button class="boton" onclick="mostrar('contenido1','contenido2')" ><h5 style="color:white; height:20px">Ver Tutorial</h5></button>
                       <br><br>
                       <button class="boton" onclick="mostrar('contenido2','contenido1')" ><h5 style="color:white; height:20px">Ver Partidas</h5></button>
                       
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 co-sm-l2"  id="contenido1">
                    <div class="about_box">
                        <center>
                        <video src="{{ asset('videos/tutorial.mp4') }}" controls width="640" height="360"  ></video>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 co-sm-l2" style="display:none" id="contenido2">
                    <div class="about_box">
                        <center>
                        <div class="table-responsive"  >
                            <?php
                            $partidas=array();
                            $user=Auth::user()->id;
                            $partidausu=App\Partida_usuario::select('*')->where('id_usuario', '=',  $user)->where('activa', '=',  0)->get();
                        
                            ?>
                            <table class="table custom-table" >
                                <thead>
                                    <br>
                                    <tr>
                                    <center>
                 
                                        <th scope="col" style="width:33px"><center>Partida</center></th>
                                        <th scope="col" style="width:33px"><center>Fecha</center></th>
                                        <th scope="col" style="width:33px"><center>Ver</center></th>
                 
                                    </tr>
                                </thead>
                                <tbody>
                        
                                    @foreach( $partidausu as $it)
                                    <?php
                            
                                    $partidas=App\Partida::select('*')->where('id_partida', '=',  $it->id_partida)->where('activa', '=',  0)->get();
                        
                                    ?>
                                        @foreach($partidas as $ite)

                                        <form action="{{action('ProyectoController@InformeInd')}}" method="POST" >
                                        @csrf
                                    <tr>
                 
                                        <td><center><h6>{{$ite->id_partida}} <input name="partida" type="hidden" readonly value="{{$it->id_partida}}" ></td>
                                        <td><center><h6>{{$ite->created_at}} <input name="usuario" type="hidden" readonly value="{{$it->id_usuario}}" ></td>
                                        <?php
                                
                                         $planta=App\Planta::select('*')->where('id_partida','=',$it->id_partida)->get()->first();
                                        ?>
                                        <select name="eso" hidden>
                                            <option  value="{{$planta->id_planta}}" ></option>
                                        </select>
                                        <td><center> <a href="{{ action('ProyectoController@InformeInd') }}"  style="background-color: transparent;border:0;">
                                        <button type="submit" style="background-color: transparent;border:0;width: 33px; height: 35px"><img src="{{ asset('imagenes/pluma.png') }}" style=""></button>
                                        </a>
                                        </td>
                                    </tr>
                                        </form>
                                        @endforeach()


                                    @endforeach()
                                </tbody>
                  
                            </table>
                        </div>
                         </center>
                        <br><br>
                     </div>
                </div>
            </div>
        </div>
</div>

    <!-- end header -->
   

    <!-- end footer -->
    <!-- Javascript files-->
 
     <script src="{{ asset('moon/js/jquery.min.js') }}"></script>
     <script src="{{ asset('moon/js/custom.js') }}"></script>

    <!-- sidebar -->
    
  
 
   
    <!-- end google map js -->
</body>

</html>
