<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <style>

                table {
                 width: 100%;
                border: 1px solid #000;
                }
                th, td {
                width: 25%;
                text-align: left;
                vertical-align: top;
                    border: 1px solid #000;
                        }

           
        
                </style>


    </head>
    <body>
         <form action="{{action('ProyectoController@index')}} " method="POST">
       @csrf
       <br>
       <br>
       
                <table >
                <thead>
                
                 <tr>
                  <th scope="col">Cultivo</th>
                  <th scope="col">Cultivo</th>
                 <th scope="col">Abonar</th>
                 <th scope="col">Cosechar</th>
                 <th scope="col">Regar</th>
                 </tr>
                 </thead>
                 <tbody>
                
                 <tr>
                <td ><input type="checkbox" id="1" name="1" value="1"></td >
                <td ><input type="checkbox" id="2" name="1" value="2"></td >
                 <td ><button  id="cbox2" name="cbox2" value="Abonar" ><img src="{{ asset('imagenes/abonar.jpg') }}" style="width: 80px; height: 80px"></button></td>
                  <td ><button  id="cbox3" name="cbox2" value="Cosechar" ><img src="{{ asset('imagenes/cosechar.jpg') }}" style="width: 80px; height: 80px"></button></td>
                   <td ><button  id="cbox1" name="cbox1" value="Regar" ><img src="{{ asset('imagenes/regar.jpg') }}" style="width: 80px; height: 80px"></button></td>
                  </tr>
                 </tbody>
                  </table>
                  <br>
                  <br>
                 
                    
         
    </body>
</html>
