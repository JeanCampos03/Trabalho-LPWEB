<?php
session_start();
include('../banco.php');

$_SESSION['form_data'] = [
    'idproduto'     => $_POST['idproduto'] ?? '',
    'descricao'     => $_POST['descricao'] ?? '',
    'preco'         => $_POST['preco'] ?? '',
    'categoria_id'  => $_POST['categoria_id'] ?? ''
];

if (
    empty($_SESSION['form_data']['idproduto']) ||
    empty($_SESSION['form_data']['descricao']) ||
    empty($_SESSION['form_data']['preco']) ||
    empty($_SESSION['form_data']['categoria_id'])
) {
    $_SESSION['error_message'] = "Todos os campos são obrigatórios.";
    header('Location: produtos_cadastrar.php');
    exit;
}

$id         = $con->real_escape_string($_SESSION['form_data']['idproduto']);
$descricao  = $con->real_escape_string($_SESSION['form_data']['descricao']);
$preco      = floatval(str_replace(',', '.', $_SESSION['form_data']['preco']));
$categoria  = intval($_SESSION['form_data']['categoria_id']);

$sql_create = "INSERT INTO produtos (id, nome, preco, categoria_id) 
               VALUES ('$id', '$descricao', '$preco', '$categoria')";

if ($con->query($sql_create)) {
    unset($_SESSION['form_data']);
    header('Location: index.php');
    exit;
} else {
    $_SESSION['error_message'] = "Erro ao cadastrar o produto: " . $con->error;
    header('Location: produtos_cadastrar.php');
    exit;
}
?>
