<?php
session_start();
if (!isset($_SESSION['usuario']) && !isset($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
}

include('../admin/banco.php');

$logado = $_SESSION['usuario'];

// Filtros recebidos via POST
$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '';
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '';
$codigo_venda = isset($_POST['codigo_venda']) ? $_POST['codigo_venda'] : '';

// MONTE SUA QUERY AQUI USANDO AS VARIÁVEIS $data_inicial, $data_final E $codigo_venda
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

// Exemplo de query filtrada
// $sql_destaques = "SELECT ... FROM vendas v ... $condicao";

// --- CONSULTAS ORIGINAIS ABAIXO (sem filtro aplicado ainda) ---
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
                        JOIN vendasitens vi on vi.produto_id = p.id";
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
  <title>FUT CAMISAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="/images/title.png">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Seja bem-vindo(a), <?php echo $logado; ?></h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <!-- Filtros -->
  <form method="POST" class="row g-3 mb-5">
    <div class="col-md-3">
      <label for="data_inicial" class="form-label">Data Inicial</label>
      <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="<?= htmlspecialchars($data_inicial) ?>">
    </div>
    <div class="col-md-3">
      <label for="data_final" class="form-label">Data Final</label>
      <input type="date" name="data_final" id="data_final" class="form-control" value="<?= htmlspecialchars($data_final) ?>">
    </div>
    <div class="col-md-3">
      <label for="codigo_venda" class="form-label">Código da Venda</label>
      <input type="text" name="codigo_venda" id="codigo_venda" class="form-control" value="<?= htmlspecialchars($codigo_venda) ?>">
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
    <?php if (count($destaques) > 0): ?>
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
            <img src="/images/<?php echo $produto['id']; ?>.png" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
              <p class="card-text">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
              <p class="card-text">ID: <?php echo $produto['id']; ?></p>
              <p class="card-text">Vendidos: <?php echo $conta_vendas; ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Nenhuma venda encontrada.</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
