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
          .circulo {
        border: 3px solid #ddd;
        width: 30rem;
        height: 30rem;
        border-radius: 50%;
        /*background: red;*/
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin:0px auto;
        padding:3%
      }

      .circulo > h2 {
        font-family: sans-serif;
        color: white;
        font-size: 1.4rem;
        font-weight: bold;
      }


      .container .row {
        /*margin: 20px;*/
        text-align: center;
      }

      .container .row a {
        /*margin: 0 20px;*/
      }
       </style>

    </head>
    <body>
        <?php

        $cult=1;
        $cultivo= App\Cultivo::select("*")
                                    ->where('id_cultivo', '=', $cult)
                                    ->get()->last();
         $planta=App\Planta::select("*")
                                    ->where('id_planta', '=', $cultivo->id_planta)
                                    ->get()->last();
        ?>
        
        
        <label for="file">File</label>
        <progress id="file" max="{{$planta->alt_max}}" value="{{$cultivo->altura}}">70%</progress>
       <div style="width:800px; height:100px;">
            <div style="float:left;width:15px; height:15px;background:#E76AFA;font-size:12px"><center>2</div>
            <div style="float:left;;margin-left:10px;width:10px; height:10px; font-size:15px">2</div>
            <img src="imagenes/logo4.PNG" style="float:left;width:100px; height:100px"/> 
            <img src="imagenes/logo5.png" style="float:left;margin-left:100px;width:100px; height:100px" />
            <img src="imagenes/logo6.png" style="float:right;width:100px; height:100px" />
       </div>
    </body>
</html>
