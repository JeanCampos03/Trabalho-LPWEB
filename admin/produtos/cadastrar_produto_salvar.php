<!DOCTYPE html>
<html lang="pt-BR">
<title>Fut Camisas</title>
<link rel="icon" type="image/png" href="\images\bolatitle.png">

<?php
include("../banco.php");

$id_produto = $_POST['idproduto'];
$descricao_produto = $_POST['descricao'];
$preco_produto = $_POST['preco'];
$id_categoria = $_POST['idcategoria'];

if ($id_produto == '' || $descricao_produto == '' || $preco_produto == '' || $id_categoria == '') {
        echo "Erro - Id, descricao, preco ou categoria não pode ser nulo";
        
        
} else  {
                $sql_create= "INSERT INTO PRODUTOS (ID, NOME, PRECO, CATEGORIA_ID) 
                VALUES ('$id_produto', '$descricao_produto', '$preco_produto', '$id_categoria' )";
                
        $con->query($sql_create);

        header('location:/admin/produtos/index.php');
}

?>

<a href="/admin/produtos/index.php" class="btn btn-primary"> Tentar Novamente </a>
</html>