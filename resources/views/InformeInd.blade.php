<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Informe</title>
  <!-- plugins:css -->

  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="shortcut icon" href="{{ asset('imagenes/logo6.png') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/style.css') }}">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/style.css') }}">
  <!-- endinject -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
   


</head>

<body >
  <div class="container-scroller" >
    
     
          <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" >

              <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background-color:#052501">
                <a class="navbar-brand brand-logo mr-5" href="/home"><img src="{{ asset('imagenes/logo6.png') }}" style=" width:30%; height: 30%" class="mr-2" alt="logo"  title="Soy un tooltip" translate="no"/></a>

                <a class="navbar-brand brand-logo-mini" href="/home"><img src="{{ asset('imagenes/logo6.png') }}" style=" width: 70%; height: 70%" alt="logo"/></a>
        
              </div>

      
      
              <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color:#052501">
      
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                  <span class="ti-view-list"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                  <li class="nav-item nav-search d-none d-lg-block">
                    <h3 style="color:white; width:auto ">Informe de Partida  {{$id_partida}}</h3>
                  </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
          
                  <li class="nav-item nav-profile dropdown">
                    <h6 style="color:white; width:auto ">{{ Auth::user()->name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h6>
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                      <img src="{{ asset('imagenes/usu.png') }}"  alt="profile"/>
                    </a>
            
                  </li>
                </ul>
              </div>
            </nav>
      
        
    <div class="container-fluid page-body-wrapper">
      

       
       <div class="content-wrapper">
           
                 <form action="{{action('ProyectoController@InformeInd')}}" method="POST" name="form2" >
                  @csrf
                     <?php
                        $partida=$id_partida;
                        $usuarios=App\User::join("partida_usuarios","partida_usuarios.id_usuario", "=", "users.id")
                                            ->select("*")
                                            ->where("partida_usuarios.id_partida", "=",$partida)
                                            ->get();
                       
                         $plantas= App\Planta::select('*')->where('id_partida', '=', $partida)->get(); 
                     ?>
            
                         <input name="partida" type="hidden" readonly value="{{$id_partida}}">
                        
                         <select name="eso">
                            @foreach($plantas as $item)
                                <option name="id_planta" id="id_planta" value="{{$item->id_planta}}">{{$item->tipo_planta}}</option>
                            @endforeach()
                         </select>
                        
                        <button type="submit">ver</button>
                     
                 </form>
                
               
            
              <div class="row">
                <div class="col-lg-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body" style="height:350px">
                    <h4 class="card-title">Cultivos sembrados</h4>
                     <center>
                    
                        <form action="/datosind" method="POST" name="form1" >
                          @csrf
                            <input type="hidden" type="text" name="id" value="{{$var}}">
                            <input type="hidden" type="text" name="partida" value="{{$id_partida}}">
                            <input type="hidden" type="text" name="user" value="{{$user}}">
                        </form>
                        <div style=" width:350px; height:150px">
                            <canvas id="oilChart" width="350" height="250"></canvas>
                       </div>
                   
                     </center>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Producción</h4>
                      <center>
                        
                           <canvas id="myCha" width="400" height="280"> 
                        
                      </center>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Comparación entre usuarios</h4>
                      <center>
                      <br>
                         <div class="table-responsive" style=" ">
                            <table class="tabla" style="width:100%; border:1px black solid">
                                <thead>
                                   <tr  style="width:100%; border:1px black solid">
                                     <th> <center>Recurso</center></th>
                                      @foreach($usuarios as $item)
                             
                                        <th> <center>{{$item->name}}</center></th>
                                 
                                      @endforeach()
                                   </tr>
                                </thead>
                                <tbody>
                        
                                 <tr>
                                     <td> <center>Cultivos</center></td>
                                     @foreach($cultivosdd as $item2)
                                
                                      <td> <center>{{$item2}}</center></td>
                              
                                     @endforeach()
                                 </tr>
                                 <tr>
                                     <td> <center>Vendidos</center></td>
                                     @foreach($cultivosv as $item2)
                                
                                      <td> <center>{{$item2}}</center></td>
                              
                                     @endforeach()
                                 </tr>
                                 <tr>
                                     <td> <center>Fallidos</center></td>
                                     @foreach($cultivosf as $item2)
                                
                                      <td> <center>{{$item2}}</center></td>
                              
                                     @endforeach()
                                 </tr>
                                 <tr>
                                    <td> <center>Agua</center></td>
                                     @foreach($agua as $item3)
                                
                                      <td> <center><?php
                                        $agua=number_format($item3,2)
                                      ?>{{$agua}}</center></td>
                              
                                     @endforeach()
                                 </tr>
                                 <tr>
                                    <td> <center>Capital</center></td>
                                     @foreach($suma as $item4)
                                         <?php
                                               $suma=number_format($item4,0)
                                            ?>
                                      <td> <center>{{$suma}}</center></td>
                              
                                     @endforeach()
                                 </tr>
                                </tbody>
                            </table>
                         </div>
                        </center>
                    </div>
                  </div>
                </div>
              </div>
               
              <div class="row">
                <div class="col-lg-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Agua utilizada por planta {{$tipo_planta}}
                            <br> <br><br>
                       <center>
                          
                            <canvas id="myChart" width="400" height="200"></canvas>
                       
                       </center>
                  
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Abono utilizado por planta {{$tipo_planta}}
                      <br> <br><br>
                       <center>
                       
                            <canvas id="myCha3" width="400" height="200"></canvas>
                        
                           
                       </center>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 grid-margin  stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Variación Precio por Planta {{$tipo_planta}}</h4>
                       <br> 
                       <center>
                          
                            <canvas id="myCha4" width="400" height="200"></canvas>
                           
                       </center>
                   
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
               
              </div>
         
        </div>
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->

  <!-- End custom js for this page-->
  <script >
       $(document).ready(function(){
            $.ajax({

                url:'/datosind',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: 'POST',
                data:{
                    id:$('input[name="id"]').val(),
                    partida:$('input[name="partida"]').val(),
                    user:$('input[name="user"]').val(),
                    _token:$('input[name="_token"]').val()
                }
            }).done(function(res){
                var plantas=res[0];
                var cantidad=res[1];
                var produccion=res[2];
                var precio=res[3];
                var semana_p=res[4];
                var agua=res[5];
                var semana_a=res[6];
                var agua_re=res[7];
                var abono=res[8];
                var semana_b=res[9];
                var abono_Re=res[10];

                    var oilCanvas = document.getElementById("oilChart");

                        var oilData = {
                            labels: plantas,
                            datasets: [
                                {
                                    data: cantidad,
                                    backgroundColor: [
                                        "#FF6384",
                                        "#63FF84",
                                        "#8463FF"
                                    ]
                                }]
                        };

                        var pieChart = new Chart(oilCanvas, {
                          type: 'pie',
                          data: oilData
                        });
                    var ctx2 = document.getElementById('myCha').getContext('2d');
                        var myCha = new Chart(ctx2, {
                        type: 'bar',
                         data: {

                        labels: plantas,
                        datasets: [{
                            label: 'Producción',
                            data: produccion,
                            backgroundColor: [
                                'rgb(255, 159, 64, 0.2)',
                                'rgba(0, 0, 255, 0.2)'
                            ],
                            borderColor: [
                                 'rgb(255, 159, 64,1)',
                                  'rgba(0, 0, 255, 1)'
                            ],
                            borderWidth: 1
                        }
                        
                        ],
                        
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                        });
                    var ctx4 = document.getElementById('myCha4').getContext('2d');
                        var myChart = new Chart(ctx4, {
                            type: 'line',
                             data: {

                            labels: semana_p,
                            datasets: [{
                                label: 'precio',
                                data: precio,
                                backgroundColor: [
                                    'rgba(255,255, 255, 0.2)'
                                ],
                                borderColor: [
                                     'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            }
                            ],
                        
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                       });
                    var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                             data: {

                            labels: semana_a,
                            datasets: [{
                                label: 'agua usada',
                                data: agua,
                                backgroundColor: [
                                    'rgba(255,255, 255, 0.2)'
                                ],
                                borderColor: [
                                     'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'agua requerida',
                                data: agua_re,
                                backgroundColor: [
                                    'rgba(255,255, 255, 0.2)'
                                ],
                                borderColor: [
                                     'rgba(0, 0, 255, 1)'
                                ],
                                borderWidth: 1
                            }
                        
                            ],
                        
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                        });
                    var ctx3 = document.getElementById('myCha3').getContext('2d');
                        var myChart = new Chart(ctx3, {
                            type: 'line',
                             data: {

                            labels: semana_b,
                            datasets: [{
                                label: 'abono usado',
                                data: abono,
                                backgroundColor: [
                                    'rgba(255,255, 255, 0.2)'
                                ],
                                borderColor: [
                                     'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'abono requerido',
                                data: abono_Re,
                                backgroundColor: [
                                    'rgba(255,255, 255, 0.2)'
                                ],
                                borderColor: [
                                     'rgba(0, 0, 255, 1)'
                                ],
                                borderWidth: 1
                            }
                        
                            ],
                        
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                       });

            });
        })
  </script>
  <script src="{{ asset('tabla/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('tabla/js/main.js') }}"></script>
</body>

</html>


