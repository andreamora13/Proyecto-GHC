
<!DOCTYPE html>
<html lang="es">
<head>
    <script>

    
        function mostrar(id)
        {
            var objeto=document.getElementById(id)
            if(objeto.style.display=="block")
                objeto.style.display="none";
            else
                objeto.style.display="block";
        }
       
    </script>

      <script src="{{ asset('moon/js/jquery.min.js') }}"></script>
     <script src="{{ asset('moon/js/custom.js') }}"></script>
    
      <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/bootstrap.min.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/style.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/responsive.css') }}">
          <link rel="stylesheet" type="text/css" href="{{ asset('css/estilo.css') }}">
    <style>

       .oculto {
        display:none;
   

         }
        
    </style>
</head>
<body class="main-layout ">

       
    
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
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     Bienvenido Usuario {{ Auth::user()->name }} <br>
                     {{ __('¡Iniciaste sesión!') }}<br>
                     <br>
                

                        <a href="{{ action('ProController@principal') }}">
                            <input  type="button" onclick="" value="Iniciar">
                            </a>
                              <br><br>
                        <input  type="button" onclick="mostrar('contenido1')"  value="Ver Tutorial">
                        <br><br>
                        <input  type="button" onclick="mostrar('contenido2')" value="Ver Partidas jugadas">
          
                         <br>
                         <center>
                        <video src="{{ asset('videos/prueba.mp4') }}" controls width="640" height="360" class="oculto" id="contenido1" ></video>
                      
                        <center>
                        <div class="oculto" id="contenido2">
                        <?php
                         $partidas=array();
                         $user=Auth::user()->id;
                         $partidascount=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->count();
                         $partidasdet=App\PartidaDet::select('*')->where('id_usuario', '=',  $user)->get();
                        
                        ?>
                        

                        <table class="table" >
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
                        
                         @foreach($partidasdet as $it)
                           <?php
                            
                             $partidas=App\Partida::select('*')->where('id_partida', '=',  $it->id_partida)->get();
                        
                           ?>
                               @foreach($partidas as $ite)

                            <form action="{{action('AdmiController@informe')}}" method="POST" >
                            @csrf
                            <tr>
                 
                            <td><center>{{$ite->id_partida}} <input name="partida" type="hidden" readonly value="{{$it->id_partida}}" ></td>
                            <td><center>{{$ite->created_at}}</td>
                            <td><center> <a href="{{ action('HomeController@indivInforme') }}">
                            <button type="submit" ><img src="{{ asset('imagenes/pluma.png') }}" style="width: 25px; height: 25px"></button>
                            
                            </a>
                            </td>
                            </tr>
                            </form>
                             @endforeach()


                          @endforeach()
                    </tbody>
                  </table>  


                  

                     
                </div>

                     
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
