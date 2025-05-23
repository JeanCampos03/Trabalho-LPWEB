<?php
session_start();
include('../admin/banco.php');

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Carrinho vazio.";
    exit;
}

$produtos = $_SESSION['carrinho'];
$data = date('Y-m-d H:i:s');

$sql_venda = "INSERT INTO vendas (data_venda) VALUES ('$data')";
if (mysqli_query($con, $sql_venda)) {
    $venda_id = mysqli_insert_id($con);
} else {
    echo "Erro ao registrar a venda.";
    exit;
}

foreach ($produtos as $produto_id => $quantidade) {
    if ($quantidade > 0) {
        $sql_item = "INSERT INTO vendasitens (venda_id, produto_id, quantidade) VALUES ($venda_id, $produto_id, $quantidade)";
        if (!mysqli_query($con, $sql_item)) {
            echo "Erro ao registrar item da venda.";
            exit;
        }
    }
}

unset($_SESSION['carrinho']);

$contagem_vendas = "SELECT COUNT(id) AS c FROM vendas";
$result = $con->query($contagem_vendas);
$n_vendas = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Compra Finalizada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container text-center mt-5">
    <div class="card shadow-sm p-4">
      <h1 class="text-success mb-3">Obrigado pela sua compra! ⚽</h1>
      <p class="fs-5">Seu pedido foi finalizado com sucesso.</p>
      <p class="fs-5">Número do Pedido: <strong>#<?= $n_vendas['c']; ?></strong></p>
      <a href="index.php" class="btn btn-primary mt-4">Voltar para a loja</a>
    </div>
  </div>

</body>
</html>
