<?php
include('../admin/banco.php');  


$consulta_produtos1 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 1";

$consulta_produtos2 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 2";

$consulta_produtos3 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 3";

$resultado1 = $con-> query($consulta_produtos1);
$resultado2 = $con-> query($consulta_produtos2);
$resultado3 = $con-> query($consulta_produtos3);

foreach ($resultado1 as $linha1);
foreach ($resultado2 as $linha2);
foreach ($resultado3 as $linha3);

$stmt = $con->query("SELECT id, nome FROM categorias");


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
  <title> FUT CAMISAS</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class = "container-login" >
    <a href="/admin/login.php" class="btn-login">Login</a>
</div>

<div class="container-filtro"> 
  <a href="filtro_todos.php" class ="filtro-todos">Todos</a>
  <a href="filtro_times_br.php" class ="filtro-todos">Times Brasileiros</a>
  <a href="filtro_times_europa.php" class ="filtro-todos">Times Europeus</a>
  <a href="index.php" class ="filtro-todos">Destaques</a>
</div>

<h2 class="titulo">🔥 Destaques</h2>
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
  <?php else: ?>
    <p>Nenhum destaque disponível.</p>
  <?php endif; ?>
</div>


  <section class="produtos-section">
    <h2 class="titulo">Destaques</h2>
    <div class="produtos-container">
      <div class="produto">
        <img src="/images/palmeiras.png" alt="Produto 1">
        <h3> <?php echo $linha2['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha2['PRECO']; ?> </p>
        <a href="#">Comprar</a>
      </div>

      <div class="produto">
        <img src="/images/spfc.png" alt="Produto 2">
        <h3> <?php echo $linha1['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha1['PRECO']; ?></p>
        <a href="#">Comprar</a>
      </div>

      <div class="produto">
        <img src="/images/sccp.png" alt="Produto 3">
        <h3> <?php echo $linha3['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha3['PRECO']; ?> </p>
        <a href="#">Comprar</a>
      </div>
    </div>
  </section>






</body>
</html>
