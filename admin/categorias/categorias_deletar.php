<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('Location: /Area_Publica/index.php');
    exit;
}

if (isset($_POST['id'])) {
    $_SESSION['id_categoria_para_deletar'] = $_POST['id'];
}

$id = $_SESSION['id_categoria_para_deletar'] ?? null;

if (!$id) {
    $_SESSION['error_message'] = "ID da categoria não foi informado.";
    header('Location: index.php');
    exit;
}

$id = (int)$id;
$sql_delete = "DELETE FROM categorias WHERE id = '$id'";

if ($con->query($sql_delete)) {
    $_SESSION['success_message'] = "Categoria excluída com sucesso.";
} else {
    $_SESSION['error_message'] = "Erro ao excluir a categoria: " . $con->error;
}

header('Location: index.php');
exit;
