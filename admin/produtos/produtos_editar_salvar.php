<!DOCTYPE html>
<html lang="pt-BR">
<title> ERROR </title>
<link rel="icon" type="image/png" href="\images\title.png">

<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">


<?php

session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true))
{
        header('location:in/Area_Publica/index.php');
  }

  
include("../banco.php");

$id = @$_POST["id"];
$nome = @$_POST["nome"];
$preco = @$_POST["preco"];
$categoria_id = @$_POST["categoria_id"];
var_dump($categoria_id);

if (!isset($id) || !isset($nome ) || !isset($preco) || !isset($categoria_id)) {
        echo "<h1 class='erro'> Existem campos nulos </h1>";
        
        
} else  {
        $mudar = "UPDATE produtos
                SET nome='$nome', preco='$preco', categoria_id= '$categoria_id'
                WHERE id= '$id'";

                var_dump($categoria_id);
                
                $con->query($mudar);

        header('location:/admin/produtos/index.php');
}

?>

<a href="/admin/produtos/index.php" class="btn-tryAgain"> Tentar Novamente </a>