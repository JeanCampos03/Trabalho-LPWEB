<?php

include("../banco.php");

session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true))
{
        header('location:in/Area_Publica/index.php');
  }

$logado = $_SESSION['usuario'];

$id = @$_POST["id"];
$nome = @$_POST["nome"];
$preco = @$_POST["preco"];
$categoria_id = @$_POST["categoria_id"];

$sql = "UPDATE produtos
            set nome='$nome',
                preco='$preco',
                categoria_id='$categoria_id'
        WHERE id='$id'";

$con->query($sql);


header("location:/admin/produtos/index.php");




?>