<?php
session_start();

include("banco.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM USUARIO 
        WHERE NOME = '$usuario' 
        AND SENHA = '$senha' ";

$con->query($sql);

$resultado = $con->query($sql);


if (mysqli_num_rows($resultado) > 0) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['senha'] = $senha;
    header('location:dashboard.php');
} else {
    header('location:/Area_Publica/index.php');
}
?>