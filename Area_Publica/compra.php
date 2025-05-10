<?php
include('../admin/banco.php'); // conexão com o banco

// Verifica se o ID foi enviado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produto inválido.";
    exit;
}

$id = (int) $_GET['id'];

// Consulta o produto
$sql = "SELECT * FROM produtos WHERE id = $id";
$resultado = $con->query($sql);

if (!$resultado || $resultado->num_rows == 0) {
    echo "Produto não encontrado.";
    exit;
}

$produto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?php echo $produto['nome']; ?> - FUT CAMISAS</title>
  <link rel="stylesheet" href="/css/styles.css">
  <style>

  </style>
</head>
<body>

<div class="produto-detalhe">
  <img src="/images/<?php echo strtolower($produto['id']); ?>.png" alt="<?php echo $produto['nome']; ?>">
  <div class="produto-info">
    <h1><?php echo $produto['nome']; ?></h1>
    <p><strong>Preço:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
    <a href="/Area_Publica/carrinho.php?add=<?php echo $produto['id']; ?>" class="botao-comprar">Adicionar ao Carrinho</a>

  </div>
</div>

</body>
</html>
