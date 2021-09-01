
<!DOCTYPE html>

<html>
<head>
    <title>Proyecto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="{{asset('css/stylesPrueba.css')}}" rel="stylesheet" text="text/css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
        if(r == 15)
        {
           reinicio();
            
           $.ajax({
                             url:'{{ action('ProController@semana')}}',
                             
                                 success: function(data) {
                                     document.body.innerHTML=data;;
                                     
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


</head>

 <?php
   $s=$semana;
  ?>

  @if ($s==0) 

    <body onload="empezar(this);">
    @else
    <body onload="funcionando();">
    @endif

<div class="cajonprin">
      @yield('inicio') 
        <h3 style="margin:-0.5% "><center>Información: </center></h3>
        <br>
          <table class="tabla">

             <tr>
             <th >Semana: </th>
             <th>Agua Total: </th>

                 @foreach($plantas as $item)
                  <th>Precio {{$item->Tipo_planta}}:</th>
                 @endforeach()
                 @foreach($plantas as $item)
                  <th>Mercado {{$item->Tipo_planta}}:</th>
                 @endforeach() 
   

             </tr>

             <tr>
             <?php
             
             $sema=App\Semana::select('*')->count();
             if($sema!=0)
                {
                   $sem=App\Semana::select('*')->get()->last();
                   $s=$sem->Semana+1;
                }else{
                    $s=1;
                }
            ?>
             <td align="center"><p id='cro'>0</p>{{$s}}</td>
            <td align="center">{{$AguaTotal}}</td>
            
            <?php
            foreach($precio as $it)
              {
            $precio2[]=intval($it->Precio);
             }
            ?>
            @foreach($precio2 as $it)
             <td align="center">{{$it}}</td>
                @endforeach()

            <?php
            foreach($merca as $ite)
              {
            $mercado[]=intval($ite->inv_acumulado);
             }
            ?>
            @foreach($mercado as $ite)
             <td align="center">{{$ite}}</td>
                @endforeach() 
   
   

            </tr>
            </table>
             <br>
            <div id="iz">
             <h4>&nbsp;Usuario:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 100px" value="{{ Auth::user()->name }}">
             Cultivos:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 80px" value="{{$Total}}">
             Agua utilizada:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 80px" value="{{$agua}}">
             Abono utilizado:<input class="sinborde" type="text" readonly="readonly" name="number" style="width: 80px" value="{{$abono}}">



           </div>
           <div id="de">
           
            <h4>&nbsp;Inventario:&nbsp;&nbsp;&nbsp;
            
           
             
               @foreach($invUser as $item )
                 <?php
                    $user=Auth::user()->id;
                    $inv= App\Inventario::select('*')->where('id_usuario', '=', $user)->count();
                     $planta= App\Planta::select('Tipo_planta')->where('id_planta', '=', $item->id_planta)->get()->last(); 
                   ?>
                    <input class="sinborde" type="text" readonly="readonly" style="width: 80px"  name="text" value=" {{$planta->Tipo_planta}}">
                  
                   <input class="sinborde" type="text" readonly="readonly" style="width: 80px"  name="number" value="{{$item->Prod_planta}}">


                @endforeach() 
               <input class="sinborde" type="text" readonly="readonly" style="width: 80px"  name="number" value="0">
           
           </div>
           
            
            
            <blockquote> </blockquote>
    </div>

    <div id="cajon1">
    <center>
       <form action="{{action('ProController@CrearCultivo')}}" method="POST">
        @csrf
      
       
                 <h4> Sembrar <br>
                  <br>
                <table class="table" style="margin:-4.5% ">
                <thead>
                
                 <tr>
                 <th scope="col">Tomate</th>
                 <th scope="col">Pimentón</th>
                 <th scope="col">Lechuga</th>
                 </tr>
                 </thead>
                 <tbody>
                
                 <tr>
                 <td ><input type="checkbox" id="cbox1" name="cbox1" value="Tomate"><img src="{{ asset('imagenes/tomate.png') }}" style="width: 50px; height: 50px"></td>
                 <td><input type="checkbox" id="cbox2" name="cbox2" value="Pimenton"><img src="{{ asset('imagenes/pimenton.png') }}" style="width: 50px; height: 50px"></td>
                 <td ><input type="checkbox" id="cbox3" name="cbox3" value="Lechuga"><img src="{{ asset('imagenes/lechuga.png') }}" style="width: 50px; height: 50px"></td>
                  </tr>
                 </tbody>
                  </table>
                  <br>
                  <button type="submit">Sembrar</button>
                 </form>

        <br>
       
     @if($visible==1)
                 <form action="{{action('ProController@Seleccion')}} " method="POST">
       @csrf
       <br>
       <br>
       
                <table >
                <thead>
                
                 <tr>
                 <th scope="col">Regar</th>
                 <th scope="col">Abonar</th>
                 <th scope="col">Cosechar</th>
                 
                 </tr>
                 </thead>
                 <tbody>
                
                 <tr>
                 <td ><button  id="cbox1" name="cbox1" value="Regar" ><img src="{{ asset('imagenes/regar.jpg') }}" style="width: 60px; height: 60px"></button></td>
                  </tr>
                 <td ><button  id="cbox2" name="cbox2" value="Abonar" ><img src="{{ asset('imagenes/abonar.jpg') }}" style="width: 60px; height: 60px"></button></td>
                  <td ><button  id="cbox3" name="cbox3" value="Cosechar" ><img src="{{ asset('imagenes/cosechar.jpg') }}" style="width: 60px; height: 60px"></button></td>
                  
                 </tbody>
                  </table>

       @else
       <br>
    Empieza a sembrar tus cultivos
    @endif
        
    </center>
        
         
    </div>

    <div id="cajon2">
    <center>
    <h4>Cultivos</h4>

    
    <table class="table">
        <thead>
        <tr>
         <th scope="col">Seleccion</th>
         <th scope="col">Planta</th>
         <th scope="col">Altura</th>
         <th scope="col">Producción</th>
         <th scope="col">Semana</th>
        </tr>
         </thead>
        <tbody>

        @foreach($detalle as $item)

       <?php
        $user=Auth::user()->id;
         $cultivos=App\Cultivo::select('*')->where('id_cultivo', '=',  $item->id_cultivo )->where('cosecha', '=', 0)->get();
        ?>
       
       

       @foreach($cultivos as $it)
         <tr>
          <th scope="row"><input type="checkbox" id="{{$it->id_cultivo}}" name="{{$it->id_cultivo}}" value="{{$it->id_cultivo}}"></th>
          <td > {{$it->Tipo_planta}}</td>
         <td>{{$it->Altura}}</td>
         <td>{{$it->Produccion}}</td>
          <td>{{$it->Semana}}</td>
        @endforeach()  
          @endforeach() 
   
     </tbody>
    </table>
    </center>
    </div>

    <div id="cajon3">
    <center>
    <h4>Cultivos Usuarios</h4>
    @foreach($usuarios as $item )
    {{$item->name}}
    <br><br>
          
    @endforeach()
    
    
     </center>
    </div>
    
       
       </form>
      

</body>
</html>
