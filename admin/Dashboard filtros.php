<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
  exit;
}

include('../admin/banco.php');
$logado = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['data_inicial'] = $_POST['data_inicial'] ?? '';
  $_SESSION['data_final'] = $_POST['data_final'] ?? '';
  $_SESSION['codigo_venda'] = $_POST['codigo_venda'] ?? '';
}

$data_inicial = $_SESSION['data_inicial'] ?? '';
$data_final = $_SESSION['data_final'] ?? '';
$codigo_venda = $_SESSION['codigo_venda'] ?? '';

$where = [];
if (!empty($data_inicial) && !empty($data_final)) {
  $where[] = "v.data BETWEEN '$data_inicial' AND '$data_final'";
}
if (!empty($codigo_venda)) {
  $where[] = "v.id = '$codigo_venda'";
}
$condicao = '';
if (!empty($where)) {
  $condicao = 'WHERE ' . implode(' AND ', $where);
}

$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC";
$resultado_destaques = $con->query($sql_destaques);
$destaques = $resultado_destaques->fetch_all(MYSQLI_ASSOC);

$sql_todos = "SELECT id, nome, preco FROM produtos";
$produtos = $con->query($sql_todos)->fetch_all(MYSQLI_ASSOC);

$sql_conta_vendas = "SELECT vi.produto_id AS produto_id, count(vi.produto_id) AS numero_vendas_itens
                     FROM vendasitens vi
                     JOIN vendas v ON v.id = vi.venda_id
                     GROUP BY vi.produto_id
                     ORDER BY numero_vendas_itens DESC";
$vendas = $con->query($sql_conta_vendas)->fetch_all(MYSQLI_ASSOC);

$total = $con->query("SELECT sum(p.preco) total_vendas FROM produtos p JOIN vendasitens vi ON vi.produto_id = p.id")->fetch_assoc();
$itens = $con->query("SELECT count(id) total_itens FROM vendasitens")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>FUT CAMISAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="/images/title.png">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Seja bem-vindo(a), <?= $logado ?></h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <form method="POST" class="row g-3 mb-5">
    <div class="col-md-3">
      <label for="data_inicial" class="form-label">Data Inicial</label>
      <input type="date" name="data_inicial" class="form-control" value="<?= htmlspecialchars($data_inicial) ?>">
    </div>
    <div class="col-md-3">
      <label for="data_final" class="form-label">Data Final</label>
      <input type="date" name="data_final" class="form-control" value="<?= htmlspecialchars($data_final) ?>">
    </div>
    <div class="col-md-3">
      <label for="codigo_venda" class="form-label">Código da Venda</label>
      <input type="text" name="codigo_venda" class="form-control" value="<?= htmlspecialchars($codigo_venda) ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>
  </form>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-bg-light mb-3">
        <div class="card-body">
          <h5 class="card-title">Itens Vendidos</h5>
          <p class="card-text fs-4"><?= $itens['total_itens']; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-light mb-3">
        <div class="card-body">
          <h5 class="card-title">Valor Total</h5>
          <p class="card-text fs-4">R$ <?= number_format($total['total_vendas'], 2, ',', '.'); ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-light mb-3">
        <div class="card-body">
          <h5 class="card-title">Item Mais Vendido</h5>
          <p class="card-text">(A ser implementado)</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-light mb-3">
        <div class="card-body">
          <h5 class="card-title">Item Menos Vendido</h5>
          <p class="card-text">(A ser implementado)</p>
        </div>
      </div>
    </div>
  </div>

  <h3 class="mb-3">Top 10 Mais Vendidos</h3>
  <div class="row">
    <?php foreach ($destaques as $produto): 
      $conta_vendas = 0;
      foreach ($vendas as $vendas_prod) {
        if ($vendas_prod['produto_id'] == $produto['id']) {
          $conta_vendas = $vendas_prod['numero_vendas_itens'];
          break;
        }
      } ?>
      <div class="col-md-3 mb-4">
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
  </div>
</div>
</body>
</html>
