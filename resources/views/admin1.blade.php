@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <!-- Styles -->
        
        <link rel="stylesheet" type="text/css" href="{{ asset('css/estilo.css') }}">
       
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
        <style>

        html, body {
        color: #FF0000; 
          }
         .vertical-menu {
 /* Set a width if you like */
       
          width: 100%;

         
            }
         

        .vertical-menu a {
        
        float: left;
         width: 25%;
        background-color: #2a5555;
 /* Grey background color */
        color: White; /* Black text color */
        display: block; /* Make the links appear below each other */
        padding: 12px; /* Add some padding */
        text-decoration: none; /* Remove underline from links */
        }
       .vertical-menu input {
        border: none;
        float: left;
        width: 25%;
        background-color: #2a5555;
 /* Grey background color */
        color: #FF0000; 
        display: block; /* Make the links appear below each other */
        padding: 12px; /* Add some padding */
        text-decoration: none; /* Remove underline from links */
        }
        .vertical-menu button {
        border: none;
        float: left;
        width: 25%;
         border-radius: 30px;
        display: block; /* Make the links appear below each other */
        padding: 10px; /* Add some padding */
        text-decoration: none; /* Remove underline from links */
        }
        
            
        .vertical-menu a:hover {
        background-color: #04AA6D; /* Dark grey background on mouse-over */
           }
           .vertical-menu input:hover {
        background-color: #04AA6D; /* Dark grey background on mouse-over */
           }
           .vertical-menu button:hover {
        background-color: #04AA6D; /* Dark grey background on mouse-over */
           }
        .oculto {
        display:none;
       

        }
       
        .oculto input{
        font-size: 12px;
       
        }

        .datos{
        float:left;
        width:33%;
        background-color:#c5e1a5;

        }
        #contenido1 table{
        width:100%;
        border-collapse: collapse;

         }
         #contenido1 table th, td{
          
          float:center;
          

         }
        
        </style>
        

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <br>
                <center>
                Bienvendido Admin:  {{ Auth::user()->name }}  
                <br>
                <br>
                <div class="vertical-menu">
            
           
                <button  class="btn btn-primary " onclick="mostrar('contenido1')">Inicializar datos</button>
                <button  class="btn btn-primary " onclick="mostrar('contenido2')" >Usuarios Registrados</button>
                <button  class="btn btn-primary " onclick="mostrar('contenido3')">Informes</button>
                 <a style="border-radius: 30px" href="{{ action('AdmiController@home') }}">Jugar</a>

                </div>
                
                 </center>
               
           
                <br>
               
            
                <div  id="contenido1">
           
                <form action="{{action('AdmiController@Datos')}}" method="POST" >
                 <center>
                 @csrf
                 Ingrese los datos iniciales de las plantas
                <br><br><br>
                <table class="table" style="margin:-4.5% ">
                <thead>
                
                 <tr>
                 <center>
                 <th scope="col"><center>Datos</center></th>
                 <th scope="col"><center>Tomate</center></th>
                 <th scope="col"><center>Pimentón</center></th>
                 <th scope="col"><center>Lechuga</center></th>
                 </tr>
                 </thead>
                 <tbody>
                
                 <tr>
                  <td ><center>Altura Máxima</center> </td>
                 <td ><input class="entrada" type="number" name="alt_mxt" > </td>
                 <td ><input type="number" name="alt_mxp" > </td>
                 <td ><input type="number" name="alt_mxl" > </td>
                  </tr>
                  <tr>
                  <td ><center>Agua Requerida</td>
                 <td ><input type="number" name="agua_ret" > </td>
                 <td ><input type="number" name="agua_rep" > </td>
                 <td ><input type="number" name="agua_rel" > </td>
                  </tr>
                  <tr>
                  <td ><center>Abono Requerida</td>
                 <td ><input type="number" name="ab_ret" > </td>
                 <td ><input type="number" name="ab_rep" > </td>
                 <td ><input type="number" name="ab_rel" > </td>
                  </tr>
                  <tr>
                  <td ><center>Tasa absorción agua</td>
                 <td ><input type="number" name="tab_at"> </td>
                 <td ><input type="number" name="tab_ap"> </td>
                 <td ><input type="number" name="tab_al"> </td>
                  </tr>
                 <tr>
                 <td ><center>Tasa absorción abono</td>
                 <td ><input type="number" name="tab_abt"> </td>
                 <td ><input type="number" name="tab_abp"> </td>
                 <td ><input type="number" name="tab_abl"> </td>
                 </tr>
                 <tr>
                 <td ><center>Producción</td>
                 <td ><input type="number" name="prodt"></td>
                 <td ><input type="number" name="prodp"></td>
                 <td ><input type="number" name="prodl"> </td>
                 </tr>
                  <tr>
                 <td ><center>Precio Inicial</td>
                 <td ><input type="number" name="preciot"></td>
                 <td ><input type="number" name="preciop"></td>
                 <td ><input type="number" name="preciol"> </td>
                 </tr>
                 </tbody>
                  </table>
                  <br><br>
                  <br><br>
                  <center>
                 <table class="table" style="margin:-4.5% ">
                
                 <tbody>
                
                 <tr>
                  <td ><center>Agua Total</center> </td>
                 <td ><input type="number" name="agua_total" > </td>
                
                  </tr>
            
                 </tr>
                 </tbody>
                  </table>
                        
                 </center>
                  <br><br>
                  
                <button type="submit" class="btn btn-primary ">Guardar</button>
                </center>
                </form>
            
             

            </div>
                  <center> {{$error}}</center>
            <div class="oculto" id="contenido2">
              <table class="table" >
                <thead>
                <br>
                 <tr>
                 <center>
                 
                 <th scope="col"><center>Id</center></th>
                 <th scope="col"><center>Nombre</center></th>
                 <th scope="col"><center>Email</center></th>
                 
                 </tr>
                 </thead>
                 <tbody>
                       <?php
                         $users=App\User::all();
                      ?>
               @foreach($users as $ite)
               
                 <tr>
                    <td ><center>{{$ite->id}}</td>
                    <td><center>{{$ite->name}}</td>
                    <td ><center>{{$ite->email}}</td>
                    
             
                 </tr>
               @endforeach()
               </tbody>
                  </table>
                    </div>
                 <div class="oculto" id="contenido3">
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
                       <?php
                         $partida = App\Partida::all();
                      ?>
                    @foreach($partida as $it)
                    <form action="{{action('AdmiController@informe')}}" method="POST" >
                    @csrf
                    <tr>
                 
                    <td><center>{{$it->id_partida}} <input name="partida" type="hidden" readonly value="{{$it->id_partida}}" ></td>
                    <td><center>{{$it->created_at}}</td>
                    <td><center> <a href="{{ action('AdmiController@informe') }}">
                            <button type="submit" ><img src="{{ asset('imagenes/pluma.png') }}" style="width: 25px; height: 25px"></button>
                            
                            </a>
                            </td>
                    </tr>
                    </form>
                    @endforeach()
                    </tbody>
                  </table>  


                     
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
