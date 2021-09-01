<!DOCTYPE html>

<html>
<head>
    <title>Proyecto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="{{asset('css/stylesPrueba.css')}}" rel="stylesheet" text="text/css">

        <!-- Styles -->

</head>
<body >
    <div class="cajonprin">
      @yield('inicio') 
        <h3 style="margin:-0.5% "><center>Información: </center></h3> 
           <table class="tableini">
           <tr>
           
            <td style="border: hidden"><h4>Semana: <input class="sinborde" type="text" readonly="readonly" name="number" style="width: 80px" value="{{$Semana}}">  </td>
            <td style="border: hidden"><h4>Agua Total:<input class="sinborde" type="text" readonly="readonly" style="width: 80px" name="number" value="{{$AguaTotal}}"> </td>

            </tr>
            </table>
            <div id="iz">
             <h4>&nbsp;Usuario:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 100px" value="{{ Auth::user()->name }}">
             Cultivos:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 80px" value="{{$Total}}">
           </div>
           <div id="de">
           <h4>&nbsp;Inventario:&nbsp;&nbsp;&nbsp;
            @foreach($invUser as $item )

            {{$item->Tipo_planta}}
                <input class="sinborde" type="text" readonly="readonly" style="width: 80px"  name="number" value="{{$item->Prod_planta}}">
            @endforeach() 
           
           </div>
           
            
            
            <blockquote> </blockquote>
    </div>
    @yield('content') 
 


   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
      </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js">
    </script>
    @yield('scripts')

</body>
</html>
