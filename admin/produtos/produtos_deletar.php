<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('Location: /Area_Publica/index.php');
    exit;
}

$id_produto = $_POST['id'] ?? null;

if (!$id_produto) {
    $_SESSION['error_message'] = "ID do produto não foi informado.";
    header('Location: index.php');
    exit;
}

$id_produto = $con->real_escape_string($id_produto);
$sql_delete = "DELETE FROM produtos WHERE id = '$id_produto'";

if ($con->query($sql_delete)) {
    $_SESSION['success_message'] = "Produto excluído com sucesso.";
} else {
    $_SESSION['error_message'] = "Erro ao excluir o produto: " . $con->error;
}

header('Location: index.php');
exit;
?>
