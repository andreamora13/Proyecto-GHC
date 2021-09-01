<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Informe</title>
  <!-- plugins:css -->

  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/style.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/style.css') }}">
  <!-- endinject -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
   


</head>

<body >
  <div class="container-scroller" >
    <!-- partial:../../partials/_navbar.html -->
     
          <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" >

              <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background-color:#052501">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{ asset('imagenes/logo3.png') }}" style=" width:30%; height: 30%" class="mr-2" alt="logo"  title="Soy un tooltip" translate="no"/></a>

                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('imagenes/logo3.png') }}" style=" width: 70%; height: 70%" alt="logo"/></a>
        
              </div>

      
      
              <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color:#052501">
      
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                  <span class="ti-view-list"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                  <li class="nav-item nav-search d-none d-lg-block">
                    <h3 style="color:white; width:auto ">Informe de Partida</h3>
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
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <form action="/datosgra" method="POST" name="form1" >
         @csrf
          <input type="hidden" type="text" name="id" value="{{$var}}">
      </form>
      
     
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <h4 class="card-title">Cultivos sembrados</h4>
                 <center>
                   <div style=" width:500px; height:300px">
                        <canvas id="oilChart" width="200" height="100"></canvas>
                   </div>
                 </center>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Producción</h4>
                  <center>
                    
                  </center>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                   
                   <center>
                         
                   </center>
                  
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Abono utilizado por planta
                  <br> <br><br>
                   <center>
                         
                   </center>
                   
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Variación Precio Planta</h4>
                   <br> 
                   <center>
                            
                   </center>
                   
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Comparación entre usuarios</h4>
                  <br><br>
                  <div class="table-responsive" style=" ">
                    <table class="tabla" style="width:100%; border:1px black solid">
                       
                    </table>
                  </div> 
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        
        <!-- partial -->
      
   
  <!-- plugins:js -->
  </div>
  <!-- End custom js for this page-->
  <script >
   
      $(document).ready(function(){
            $.ajax({

                url:'/datosgra',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: 'POST',
                data:{
                     id:$('input[name="id"]').val()
                    
                }
            }).done(function(res){
                var plantas=res[0];
                var cantidad=res[1];
                 alert(res)

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

            });

     
      })
      
         
  </script>
  <script src="{{ asset('tabla/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('tabla/js/main.js') }}"></script>
</body>

</html>


