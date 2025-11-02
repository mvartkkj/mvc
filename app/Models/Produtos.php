<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model {
    public $nomeProduto;
    public $codProduto;
    public $descricaoProduto;

    public function getProduto($idprd){
        return "produto encontrado";
    }

    
    public function gravar ($nmProduto,$descProduto){
        DB::insert('insert into produtos (nome_produto,descricao_produto) values (?,?)', [$nmProduto,$descProduto]);
        
    }
    

    public function listarProdutos (){
        $listaProdutosDoBanco = DB::select('select * from produtos order by cod_produto DESC');
        return $listaProdutosDoBanco;
    }

}
?>
