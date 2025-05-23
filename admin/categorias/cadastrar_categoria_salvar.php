<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:/Area_Publica/index.php');
    exit;
}

$nome = trim($_POST['nome_categoria'] ?? '');

if ($nome === '') {
    echo "<h3 class='text-center text-danger mt-5'>O nome da categoria é obrigatório.</h3>";
    echo "<div class='text-center'><a href='criar_categoria.php' class='btn btn-warning mt-3'>Voltar</a></div>";
    exit;
}

$sql = "INSERT INTO categorias (nome) VALUES ('$nome')";
$con->query($sql);

header("Location: index.php");
exit;
