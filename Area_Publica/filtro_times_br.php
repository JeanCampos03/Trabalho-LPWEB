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
$sql_brasileiros = "SELECT p.id, p.nome, p.preco
                    FROM produtos p
                    JOIN categorias c ON p.categoria_id = c.id
                    WHERE c.id = 1";

$resultado_todos = $con->query($sql_brasileiros);

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

  </style>
</head>
<body>

<div class="container-login">
  <a href="/admin/login.php" class="btn-login">Login</a>
</div>

<div class="container-filtro"> 
  <a href="filtro_todos.php" class ="filtro-todos">Todos</a>
  <a href="filtro_times_br.php" class ="filtro-todos">Times Brasileiros</a>
  <a href="filtro_times_europa.php" class ="filtro-todos">Times Europeus</a>
  <a href="index.php" class ="filtro-todos">Destaques</a>

</div>

<div class="produtos-grid">
  <?php if (count($destaques) > 0): ?>
    <?php foreach ($destaques as $produto): ?>
      <div class="produto">
        <img src="/images/<?php echo $produto['id']; ?>.png" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>
        <p class="preco">R$ <?php echo number_format($produto['preco'], 1, ',', '.'); ?></p>
        <!---<a href="#">Comprar</a>-->
        <a href="compra.php?id=<?php echo $produto['id']; ?>">Comprar</a>
      </div>
    <?php endforeach; ?>
 
  <?php endif; ?>
</div>

<h2 class="titulo"> 🌎 Times do Brasil </h2>
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
