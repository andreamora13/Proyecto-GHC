


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
    <title>Admin</title>
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
        function mostrar(id, id2, id3)
        {
            var objeto=document.getElementById(id);
            var objeto2=document.getElementById(id2);
            var objeto3=document.getElementById(id3);
            if(objeto.style.display=="block")
                objeto.style.display="none";
            else
                objeto.style.display="block";
                objeto2.style.display="none";
                objeto3.style.display="none";
        }
     </script>

     <style>


        .oculto {
            display:none;
        }
     </style>


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout " style="background-image: linear-gradient(to right,#006341, #a7f25e)">
 <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Inicio
                </a>
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                 </div>
                 <div class="container">
                        @else

                                <a class="navbar-brand" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            
                        @endguest
                    </ul>
               </div>
            </div>
  </nav>
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
                                    <a href="/"> <img src="{{ asset('imagenes/logo3.png') }}" style=" width: 30%; height: 30%"></a>
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
                <div class="row" >
                    <div class="col-md-12 location_icon_bottum">
                       <div class="row"style="height:70px">
                            <div class="col-md-8 ">
                                <div class="menu-area">
                                    <div class="limit-box">
                                        <nav class="main-menu">
                                            <ul class="menu-area-main">
                                              
                                                <li> <a href="{{ action('AdmiController@home') }}" ><p  style="font-family:poppins;font-size:15px">Inicio</p></a></li>
                                                <li> <button   onclick="mostrar('contenido1','contenido2','contenido3')" ><p  style="font-family:poppins">Inicializar datos</p></button> </li>
                                                <li> <button  onclick="mostrar('contenido2','contenido1','contenido3')" ><p  style="font-family:poppins">Usuarios Registrados</p></button></li>
                                                <li><button  onclick="mostrar('contenido3','contenido1','contenido2')"><p  style="font-family:poppins;font-size:15px">Informes</p></button></li>
                                                
                                                

                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                            </div>
                            
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header inner -->
    </header>

    <!-- about -->
    <div id="about" class="about">
        <div class="container">
           
            <center>
            <div class="table-responsive" style="display:none" id="contenido1" value="contenido1">
            <a href="{{ action('AdmiController@defecto') }}"  style="text-align: right"><p  style="font-family:poppins;font-size:15px;border:1px solid black;width:150px; ">Datos por defecto</p></a>
                <form action="{{action('AdmiController@Datos')}}" method="POST" style="border: #082404 3px solid;" >
                <center>
                 @csrf
                 <h5>Ingrese los datos iniciales de las plantas 
                <br>
                    <table class="table custom-table">
                     <thead>
                       <tr>
              
                        <th scope="col"><center>Datos</center></th>
                        <th scope="col"><center>Tomate</center></th>
                        <th scope="col"><center>Pimentón</center></th>
                        <th scope="col"><center>Lechuga</center></th>
                       </tr>
                     </thead>
                     <tbody>
         
                       <tr>
             
                        <td ><center><p>Altura Máxima</p></center> </td>
                        <td ><center><input class="entrada" type="number" name="alt_mxt" step="any"  ></td>
                        <td ><center><input type="number" name="alt_mxp" step="any"  > </td>
                        <td ><center><input type="number" name="alt_mxl"step="any"  > </td>
                       </tr>
                       <tr>
                        <td ><center><p>Agua Requerida</td>
                        <td ><center><input type="number" name="agua_ret" step="any" > </td>
                        <td ><center><input type="number" name="agua_rep" step="any" > </td>
                        <td ><center><input type="number" name="agua_rel" step="any" > </td>
                       </tr>
                       <tr>
                        <td ><center><p>Abono Requerido</td>
                        <td ><center><input type="number" name="ab_ret" step="any" > </td>
                        <td ><center><input type="number" name="ab_rep" step="any" > </td>
                        <td ><center><input type="number" name="ab_rel" step="any" > </td>
                       </tr>
                       
                       <tr>
                        <td ><center><p>Producción</td>
                        <td ><center><input type="number" name="prodt" step="any" ></td>
                        <td ><center><input type="number" name="prodp" step="any" ></td>
                        <td ><center><input type="number" name="prodl" step="any" > </td>
                       </tr>
                       <tr>
                        <td ><center><p>Precio Inicial</td>
                        <td ><center><input type="number" name="preciot" step="any" ></td>
                        <td ><center><input type="number" name="preciop" step="any" ></td>
                        <td ><center><input type="number" name="preciol" step="any" > </td>
                       </tr>
            
            
                     </tbody>
                    </table>
                    <br><br>
                
                    <center>
                    <table class="table" style="margin:-4.5% ">
                
                      <tbody>
                
                       <tr>
                        <td ><center><p>Agua Total</center> </td>
                        <td ><input type="number" name="agua_total" step="any" > </td>
                
                       </tr>
            
                       
                      </tbody>
                    </table>
                        
                    </center>
                    <br><br>
                    <center><button type="submit" class="btn btn-primary " style="background-color: #082404">Guardar</button>
               
                </form>
            </div>
            </center>
            
              <center><b> {{$error}}</b></center>
            <div class="table-responsive" style="display:none" id="contenido2">

                 <table class="table custom-table">
                     <thead>

                        <br>
                        <tr>
                        <center>
                 
                            <th scope="col"><center>Id</center></th>
                            <th scope="col"><center>Nombre</center></th>
                            <th scope="col"><center>Email</center></th>
                            <th scope="col"><center>Tipo Usuario</center></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                         $users=App\User::all();
                        ?>
                        @foreach($users as $ite)
                        <?php
                         $tipo=App\TipoUsuario::select('*')->where('id_usuario','=',$ite->id)->count();
                        ?>
                        <tr>
                            <td ><center><p style="color:black"><b>{{$ite->id}}</td>
                            <td><center><p style="color:black"><b>{{$ite->name}}</td>
                            <td ><center><p style="color:black"><b>{{$ite->email}}</td>
                            @if($tipo != 0)
                                <?php
                                 $tipo=App\TipoUsuario::select('*')->where('id_usuario','=',$ite->id)->get()->last();
                                 $tipousu=App\Tipo::select('*')->where('id_tipo','=',$tipo->id_tipo)->get()->last();
                                 $tiposusu=App\Tipo::select('*')->get();
                                ?>
                                <td ><center><p style="color:black"><b>{{$tipousu->tipo_usu}}</td>
                            @else
                                <form action="{{action('AdmiController@Asignacion')}}" method="POST" >
                                  @csrf  
                                    <td ><center><p style="color:black">
                                     <input type="number" name="id" hidden value="{{$ite->id}}" style="width: 25px; height: 25px">
                                     <select name="usu">
                                       @foreach($tiposusu as $type)
                                        <option  value="{{$type->id_tipo}}">{{$type->tipo_usu}}</option>
                                       @endforeach()
                                     </select>
                                      <button type="submit" style="background-color: transparent;width: 75px; height: 25px; border: solid 1px black"> Guardar</button>
                                    </td>
                                </form>
                            @endif()
             
                        </tr>
                        @endforeach()
                    </tbody>
                 </table>
                  

            </div>
            </center>
            <div class="table-responsive"  style="display:none" id="contenido3">

                 <table class="table custom-table">
                    <thead>
                      <br>
                        <tr>
                            <center>
                 
                            <th scope="col"><center>Partida</center></th>
                            <th scope="col"><center>Fecha</center></th>
                            <th scope="col"><center>Ver</center></th>
                 
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                         $partida = App\Partida::all();
                         
                        ?>
                        @foreach($partida as $it)
                        <form action="{{action('ProyectoController@InformeGlo')}}" method="POST" >
                        @csrf
                        <tr>
                 
                            <td><center><p style="color:black">{{$it->id_partida}} <input name="partida" type="hidden" readonly value="{{$it->id_partida}}" ></td>
                            
                                <select name="select" hidden>
                                 <b><option name="id_usuario" id="id_usuario" value="todos" ></option>
                                </select>
                                <?php
                                
                                 $planta=App\Planta::select('*')->where('id_partida','=',$it->id_partida)->get()->first();
                                ?>
                                <select name="eso" hidden >
                                 <b><option  value="{{$planta->id_planta}}" ></option>
                                </select>
                           
                            <td><center><p style="color:black"><b>{{$it->created_at}}</td>
                            <td><center> <p style="color:black">
                            <a href="{{action('ProyectoController@InformeGlo')}}">
                            <button type="submit" style="background-color: #fff;width: 25px; height: 25px"><img src="{{ asset('imagenes/pluma.png') }}" style=""></button>
                            
                            </a>
                            </td>
                        </tr>
                        </form>
                        @endforeach()
                    </tbody>
                 </table>
                  

            </div>
            </center>
        </div>
    </div>
    <!-- end about -->
    <!-- for_box -->
    

    <!-- end header -->
   

    <!-- end footer -->
    <!-- Javascript files-->
 
     <script src="{{ asset('moon/js/jquery.min.js') }}"></script>
     <script src="{{ asset('moon/js/custom.js') }}"></script>
         <script src="{{ asset('tabla/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('tabla/js/main.js') }}"></script>
    <!-- sidebar -->
    
  
 
   
    <!-- end google map js -->
</body>

</html>

