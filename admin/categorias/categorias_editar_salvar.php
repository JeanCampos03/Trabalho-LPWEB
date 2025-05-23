<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:/Area_Publica/index.php');
    exit;
}

$id = trim($_POST['id'] ?? '');
$nome = trim($_POST['nome'] ?? '');

if ($id === '' || $nome === '') {
    echo "<h3 class='text-center text-danger mt-5'>Campos obrigatórios não preenchidos.</h3>";
    echo "<div class='text-center'><a href='index.php' class='btn btn-warning mt-3'>Voltar</a></div>";
    exit;
}

$sql = "UPDATE categorias SET nome = '$nome' WHERE id = '$id'";
$con->query($sql);

header("Location: index.php");
exit;
