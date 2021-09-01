@extends('maestro')

@section('inicio')
  
     <div class="content">
       
     
 
    </div>


@stop
@section('content')

    <div id="cajonA">
    <center>
       Tomate
       <br>
       <br>
       Precio Inicial: {{$precioT}} 
     </center>
     </div>

     <div id="cajonB">
     <center>
      Pimenton
      <br>
      <br>
      Precio Inicial: {{$precioP}}
      
      </center>
     </div>

     <div id="cajonC">
     <center>
      Lechuga
      <br>
      <br>
      Precio Inicial: {{$precioL}} 
      </center>
     </div>

     @stop
