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
       <h1>Cadastro de produtos</h1>
       @if( !empty($dado))
            {{$dado}}
      @endif
                
     
 
       


       <div class="container">
            <form action="/produtos/cadastrar" method="post">
            @csrf
              <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix">collections</i>
                  <input type="text" id="icon_prefix2" class="materialize-textarea" name="formNomeProduto"/>
                  <label for="icon_prefix2">Nome Produto</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">format_list_numbered</i>
                  <input type="text" id="icon_prefix2" class="materialize-textarea" name="formQtdProduto"/>
                  <label for="icon_prefix2">Quantidade comprada</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix">attach_money</i>
                  <input type="text" id="icon_prefix2" class="materialize-textarea" name="formValorProduto"/>
                  <label for="icon_prefix2">Valor Produto</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">contact_phone </i>
                  <input type="text" id="icon_prefix2" class="materialize-textarea" name="formFornecedorProduto"/>
                  <label for="icon_prefix2">Fornecedor Produto</label>
                </div>
              </div>
              <div class="row">
                <div class="col s6 offset-s6"><input type="submit" value="GRAVAR" class="btn waves-effect waves-light" name="formBtnProduto"></div>
              </div>
            </form>

       </div>
    </body>
</html>
