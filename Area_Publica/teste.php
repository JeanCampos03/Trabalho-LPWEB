<?php
include('../admin/banco.php');

// Destaques (os 3 mais vendidos)
$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC
                  LIMIT 3";
$resultado_destaques = $con->query($sql_destaques);

$destaques = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $destaques[] = $linha;
    }
}

// Todos os produtos
$sql_todos = "SELECT id, nome, preco FROM produtos";
$resultado_todos = $con->query($sql_todos);

$produtos = [];
if ($resultado_todos && $resultado_todos->num_rows > 0) {
    foreach ($resultado_todos as $linha) {
        $produtos[] = $linha;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>FUT CAMISAS</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="/css/styles.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    .container-login { text-align: right; padding: 10px; }
    .btn-login { text-decoration: none; padding: 8px 12px; background-color: #333; color: white; border-radius: 5px; }
    .titulo { text-align: center; margin-top: 20px; font-size: 24px; }

    .produtos-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 20px;
    }

    .produtos-grid .produto {
      width: 200px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 10px;
      text-align: center;
    }

    .produto img {
      width: 100%;
      height: auto;
    }

    .preco {
      font-weight: bold;
      color: green;
    }
  </style>
</head>
<body>

<div class="container-login">
  <a href="/admin/login.php" class="btn-login">Login</a>
</div>

<h2 class="titulo">Destaques 🔥</h2>
<div class="produtos-grid">
  <?php if (count($destaques) > 0): ?>
    <?php foreach ($destaques as $produto): ?>
      <div class="produto">
        <img src="/images/<?php echo $produto['id']; ?>.png" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>
        <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
        <!---<a href="#">Comprar</a>-->
        <a href="compra.php?id=<?php echo $produto['id']; ?>">Comprar</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nenhum destaque disponível.</p>
  <?php endif; ?>
</div>

<h2 class="titulo">Todos os Produtos 🛒</h2>
<div class="produtos-grid">
  <?php if (count($produtos) > 0): ?>
    <?php foreach ($produtos as $produto): ?>
      <div class="produto">
        <img src="/images/<?php echo $produto['id']; ?>.png" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>
        <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
        <!---<a href="#">Comprar</a>-->
        <a href="compra.php?id=<?php echo $produto['id']; ?>">Comprar</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nenhum produto cadastrado.</p>
  <?php endif; ?>
</div>

</body>
</html>
