<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Meu Restaurante</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>       

        <link href="{{ asset('css/meucss.css') }}" rel="stylesheet"> 
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
       <h1>Produtos disponíveis</h1>

       <div class="container">
        <div class="row">
            @foreach($listaProdutos as $prd)
            <div class="col s3">
              <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="images/office.jpg">
                </div>
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4">{{$prd->nome_produto}} ...</span>
                  <p><a href="#">Comprar</a></p>
                </div>
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4">{{$prd->nome_produto}}<i class="material-icons right">close</i></span>
                  <p>{{$prd->descricao_produto}}</p>
                </div>
              </div></div>
                @endforeach    
              
            </div> 

       </div>
    </body>
</html>
