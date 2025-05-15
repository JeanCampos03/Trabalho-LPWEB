<?php
session_start();
if(!isset ($_SESSION['usuario']) && !isset ($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
}

include('../admin/banco.php');
$logado = $_SESSION['usuario'];

//
$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC 
                  LIMIT 10";
$resultado_destaques = $con->query($sql_destaques);

$destaques = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $destaques[] = $linha;
        
    }
}

$top1 = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $top1 = $linha;
    }
}

$sql_todos = "SELECT id, nome, preco FROM produtos";
$resultado_todos = $con->query($sql_todos);

$produtos = [];
if ($resultado_todos && $resultado_todos->num_rows > 0) {
    foreach ($resultado_todos as $linha) {
        $produtos[] = $linha;
    }
}

$sql_conta_vendas = "SELECT vi.produto_id AS produto_id, count(vi.produto_id) AS numero_vendas_itens 
                     FROM vendasitens vi
                     JOIN vendas v ON v.id = vi.venda_id
                     GROUP BY vi.produto_id
                     ORDER BY numero_vendas_itens DESC";
$resultado_vendas = $con->query($sql_conta_vendas);

$vendas = [];
if ($resultado_vendas && $resultado_vendas->num_rows > 0) {
    foreach ($resultado_vendas as $linha) {
        $vendas[] = $linha;
    }
}

$total_vendas_valor = "SELECT sum(p.preco) total_vendas 
                 FROM produtos p
                 JOIN vendasitens vi 
                 on vi.produto_id = p.id";
$resultado_total_valor = $con->query($total_vendas_valor);

$total = [];
foreach ($resultado_total_valor as $linha) {
    $total = $linha;
}

$total_vendas_itens = "SELECT count(id) total_itens FROM vendasitens";
$resultado_total_itens = $con->query($total_vendas_itens);

$itens = [];
foreach ($resultado_total_itens as $linha) {
  $itens = $linha;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>FUT CAMISAS - Dashboard</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Bem-vindo(a), <?= $logado ?></h4>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <h1 class="text-center mb-4">DASHBOARD</h1>

  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary h-100">
        <div class="card-body">
          <h5 class="card-title">Itens Vendidos</h5>
          <p class="card-text fs-4"><?= $itens['total_itens'];?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-success h-100">
        <div class="card-body">
          <h5 class="card-title">Valor Total</h5>
          <p class="card-text fs-4">R$ <?= number_format($total['total_vendas'], 2, ',', '.'); ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-warning text-dark h-100">
        <div class="card-body">
          <h5 class="card-title">Item Mais Vendido</h5>
          <p class="card-text"> </p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-danger text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Item Menos Vendido</h5>
          <p class="card-text"><?php echo $top1['nome'] ?></p>
        </div>
      </div>
    </div>
  </div>

  <nav class="mb-4">
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link" href="categorias/index.php">Categorias</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="produtos/index.php">Produtos</a>
      </li>
    </ul>
  </nav>

  <h2 class="mb-3">Top 10 Mais Vendidos</h2>
  <div class="row row-cols-1 row-cols-md-5 g-4">
    <?php if (count($destaques) > 0): ?>
      <?php foreach ($destaques as $produto): 
        $conta_vendas = 0;
        foreach ($vendas as $vendas_prod) {
          if ($vendas_prod['produto_id'] == $produto['id']) {
            $conta_vendas = $vendas_prod['numero_vendas_itens'];
            break;
          }
        } ?>
        <div class="col">
          <div class="card h-100">
            <img src="/images/<?= $produto['id'] ?>.png" class="card-img-top" alt="<?= $produto['nome'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $produto['nome'] ?></h5>
              <p class="card-text">Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
              <p class="card-text">ID: <?= $produto['id'] ?></p>
              <p class="card-text">Vendidos: <?= $conta_vendas ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-muted">Nenhuma venda ainda.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
