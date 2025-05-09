<?php
include('../admin/banco.php');

if (!isset($_POST['produto_id']) || !isset($_POST['quantidade'])) {
    echo "Nenhum produto recebido.";
    exit;
}

$produtos = $_POST['produto_id'];
$quantidades = $_POST['quantidade'];

if (count($produtos) !== count($quantidades)) {
    echo "Erro nos dados enviados.";
    exit;
}

$data = date('Y-m-d H:i:s');
$sql_venda = "INSERT INTO vendas (data_venda) VALUES ('$data')";
if (mysqli_query($con, $sql_venda)) {
    $venda_id = mysqli_insert_id($con);
} else {
    echo "Erro ao registrar a venda.";
    exit;
}

for ($i = 0; $i < count($produtos); $i++) {
    $produto_id = $produtos[$i];
    $quantidade = $quantidades[$i];

    if ($quantidade > 0) {
        $sql_item = "INSERT INTO vendasitens (venda_id, produto_id, quantidade) VALUES ($venda_id, $produto_id, $quantidade)";
        if (!mysqli_query($con, $sql_item)) {
            echo "Erro ao registrar item da venda.";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Compra Finalizada</title>
</head>
<body>
    <h2>Compra finalizada com sucesso!</h2>
    <p>Número da venda: <?= $venda_id ?></p>
    <a href="produtos.php">Voltar à loja</a>
</body>
</html>
