<?php

include("../banco.php");

session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true))
{
        header('location:in/Area_Publica/index.php');
  }

$id= @$_POST["id"];
$nome = @$_POST["nome"];

$sql = "UPDATE categorias
            set id = '$id',
            nome='$nome'
            WHERE id='$id'";

$con->query($sql);


header("location:/admin/categorias/index.php");




?>