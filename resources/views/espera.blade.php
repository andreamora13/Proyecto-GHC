


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
    <script type="text/javascript">
    function actualizar(){location.reload(true);}
    //Función para actualizar cada 20 segundos(20000 milisegundos)
    setInterval("actualizar()",20000);
    </script>


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
                                    <a href="index.html"> <img src="{{ asset('imagenes/logo3.png') }}" style=" width: 30%; height: 30%"></a>
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
                       <center><p>Espera por otros usuarios</p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 co-sm-l2"  id="contenido1">
                    <div class="about_box">
                        <center>
                        <video src="{{ asset('videos/prueba.mp4') }}" controls width="640" height="360"  ></video>
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
