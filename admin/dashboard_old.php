<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
  exit;
}

include('../admin/banco.php');
$logado = $_SESSION['usuario'];

$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC";

$resultado_destaques = $con->query($sql_destaques);

$destaques = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $destaques[] = $linha;
        
    }
}

$top = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $top[] = $linha;
    }
  $primeiro = $top[0];
  $ultimo = $top[count($top) - 1];

} else {
  $primeiro['nome'] = "Sem vendas ainda.";
  $ultimo['nome'] = "Sem vendas ainda.";
}


$produtos = $con->query("SELECT id, nome, preco FROM produtos")->fetch_all(MYSQLI_ASSOC);

$vendas = $con->query("SELECT vi.produto_id, COUNT(vi.produto_id) AS numero_vendas_itens 
                       FROM vendasitens vi JOIN vendas v ON v.id = vi.venda_id 
                       GROUP BY vi.produto_id 
                       ORDER BY numero_vendas_itens DESC")->fetch_all(MYSQLI_ASSOC);

$total = $con->query("SELECT SUM(p.preco) total_vendas 
                      FROM produtos p 
                      INNER JOIN vendasitens vi ON vi.produto_id = p.id")->fetch_assoc();

$itens = $con->query("SELECT SUM(quantidade) total_itens 
FROM vendasitens")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>FUT CAMISAS - Dashboard</title>
  <link rel="icon" href="/images/title.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
          <p class="card-text fs-4"><?= $itens['total_itens'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success h-100">
        <div class="card-body">
          <h5 class="card-title">Valor Total</h5>
          <p class="card-text fs-4">R$ <?= number_format($total['total_vendas'], 2, ',', '.') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-warning text-dark h-100">
        <div class="card-body">
          <h5 class="card-title">Item Mais Vendido</h5>
          <p class="card-text"><?= $primeiro['nome'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-danger text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Item Menos Vendido</h5>
          <p class="card-text"><?= $ultimo['nome'] ?></p>
        </div>
      </div>
    </div>
  </div>

  <nav class="mb-4">
    <ul class="nav nav-pills justify-content-center">
      <li class="nav-item">
        <a class="btn btn-secondary mx-2" href="categorias/index.php">Categorias</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-secondary mx-2" href="produtos/index.php">Produtos</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-secondary mx-2" href="vendas/index.php">Detalhe vendas</a>
      </li>
    </ul>
  </nav>

  <h2 class="mb-3">Top 10 Mais Vendidos</h2>
  <div class="row row-cols-1 row-cols-md-5 g-4">
    <?php $i = 0 ; if (count($destaques) > 0 ): ?>
      <?php foreach ($destaques as $produto):
        $conta_vendas = 0;
        foreach ($vendas as $vendas_prod) {
          if ($vendas_prod['produto_id'] == $produto['id']) {
            $conta_vendas = $vendas_prod['numero_vendas_itens'];
            break;
          }
        } if ($i < 10) {?>
        <div class="produtos-grid">
          <div class="produto">
            <img src="/images/<?php echo $produto['id'] ?>.png" class="card-img-top" alt="<?php echo $produto['nome'] ?>">
              <h5 class="card-title"><?= $produto['nome'] ?></h5>
              <p class="preco">Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
              <p>ID: <?= $produto['id'] ?></p>
              <p>Vendidos: <?php echo $produto['qtde'] ?></p>
          </div> 
        </div>
        <?php $i++; }?>

            <?php endforeach; ?>
          <?php else: ?>
              <p>Nenhuma venda ainda.</p>
          <?php endif; ?>
</body>
</html>
