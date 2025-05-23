<?php
include("banco.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql_create = "INSERT INTO USUARIO
(NOME, SENHA) 
VALUES ('$usuario', '$senha' )";

$con->query($sql_create);
header('location:login.php');
?>
