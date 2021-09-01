<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      
    </script>
  </head>
  <body>
  <?php
    $partida=App\Partida::select('id_partida')->get()->last();
        $plantas=App\Planta::select('*')->where('id_partida','=',$partida->id_partida)->get();
        
        $usuarios= App\PartidaUsuario::join("users","users.id", "=", "partida_usuarios.id_usuario")
                                    ->select("*")
                                    ->where("partida_usuarios.id_partida", "=",$partida->id_partida)
                                    ->get();
     
  ?>
    
               @foreach($usuarios as $item)
                 
                     {{$item->name}}
                          <?php
                            
                              $partida=App\Partida::select('id_partida')->get()->last();
                              foreach($plantas as $plan)
                              {
               
                              $planta_cultivocount[]=App\Cultivo::select('*')->where("id_usuario", "=", $item->id)
                                                                             ->where("id_planta", "=", $plan->id_planta)->count();
               
                              }
                          ?>
                     @foreach($planta_cultivocount as $item3)
                     {{$item3}}
                     @endforeach()
                 <br>
               @endforeach()
               
               
        
  </body>
</html>
