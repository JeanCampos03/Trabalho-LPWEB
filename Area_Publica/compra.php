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
    .produto-detalhe {
      display: flex;
      max-width: 900px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      background: #fff;
    }
    .produto-detalhe img {
      max-width: 300px;
      border-radius: 10px;
    }
    .produto-info {
      margin-left: 30px;
    }
    .produto-info h1 {
      margin-bottom: 10px;
    }
    .produto-info p {
      font-size: 18px;
      margin-bottom: 20px;
    }
    .botao-comprar {
      padding: 10px 20px;
      background-color: #0a74da;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .botao-comprar:hover {
      background-color: #094ab2;
    }
  </style>
</head>
<body>

<div class="produto-detalhe">
  <img src="/images/<?php echo strtolower($produto['id']); ?>.png" alt="<?php echo $produto['nome']; ?>">
  <div class="produto-info">
    <h1><?php echo $produto['nome']; ?></h1>
    <p><strong>Preço:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Produto 100% original, qualidade garantida.</p>
<<<<<<< HEAD
    <a href="/carrinho.php?add=<?php echo $produto['id']; ?>" class="botao-comprar">Adicionar ao Carrinho</a>
=======
    <a href="/Area_Publica/carrinho.php?add=<?php echo $produto['id']; ?>" class="botao-comprar">Adicionar ao Carrinho</a>
>>>>>>> 83d0e93b353c2b87b40fbebc9afcdbb2815e63b4
  </div>
</div>

</body>
</html>
