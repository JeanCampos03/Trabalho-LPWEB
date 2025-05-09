<?php
<<<<<<< HEAD
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

$con->begin_transaction();

$data = date('Y-m-d H:i:s');
$stmt = $con->prepare("INSERT INTO vendas (data_venda) VALUES (?)");
$stmt->bind_param("s", $data);

if (!$stmt->execute()) {
    $con->rollback();
    echo "Erro ao registrar a venda.";
    exit;
}

$venda_id = $stmt->insert_id;

$stmt_item = $con->prepare("INSERT INTO vendasitens (venda_id, produto_id, quantidade) VALUES (?, ?, ?)");

for ($i = 0; $i < count($produtos); $i++) {
    $produto_id = intval($produtos[$i]);
    $quantidade = intval($quantidades[$i]);

    if ($quantidade > 0) {
        $stmt_item->bind_param("iii", $venda_id, $produto_id, $quantidade);
        if (!$stmt_item->execute()) {
            $con->rollback();
            echo "Erro ao registrar item da venda.";
            exit;
        }
    }
}

$con->commit();
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
=======
// temporario
echo "<link rel='stylesheet' href='/css/styles.css'>";
echo "<h1 class='titulo'> OBRIGADO PELA COMPRA! </h1>";
echo "<a href='index.php' class='container-filtro' >Inicio</a>";

?>
>>>>>>> 83d0e93b353c2b87b40fbebc9afcdbb2815e63b4
