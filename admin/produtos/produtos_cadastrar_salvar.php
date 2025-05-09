<!DOCTYPE html>
<html lang="pt-BR">
<title> ERROR </title>
<link rel="icon" type="image/png" href="\images\title.png">


<?php
include('../banco.php');

$id_produto = $_POST['idproduto'];
$descricao_produto = $_POST['descricao'];
$preco_produto = $_POST['preco'];
$id_categoria = $_POST['idcategoria'];

if ($id_produto == '' || $descricao_produto == '' || $preco_produto == '' || $id_categoria == '') {
        echo " <h1> Id, descricao, preco ou categoria não pode ser nulo </h1>";
        
        
} else  {
                $sql_create= "INSERT INTO PRODUTOS (ID, NOME, PRECO, CATEGORIA_ID) 
                VALUES ('$id_produto', '$descricao_produto', '$preco_produto', '$id_categoria' )";
                
        $con->query($sql_create);

        header('location:/admin/produtos/index.php');
}

?>

<a href="/admin/produtos/produtos_cadastrar.php" class="btn btn-primary"> Tentar Novamente </a>
</html>