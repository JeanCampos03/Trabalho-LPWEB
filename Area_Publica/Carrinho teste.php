<?php 
session_start();
include('../admin/banco.php');

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Atualizar quantidades (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    foreach ($_POST['quantidade'] as $id => $qtd) {
        $id = (int) $id;
        $qtd = (int) $qtd;
        if ($qtd <= 0) {
            unset($_SESSION['carrinho'][$id]);
        } else {
            $_SESSION['carrinho'][$id] = $qtd;
        }
    }
    header('Location: carrinho.php');
    exit;
}

$produtos = [];
if (!empty($_SESSION['carrinho'])) {
    $ids = array_keys($_SESSION['carrinho']);
    $idlist = implode(",", array_map('intval', $ids));
    $query = "SELECT * FROM produtos WHERE id IN ($idlist)";
    $result = $con->query($query);

    while ($linha = $result->fetch_assoc()) {
        $pid = $linha['id'];
        $linha['quantidade'] = $_SESSION['carrinho'][$pid];
        $produtos[] = $linha;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="mb-4 text-center">Seu Carrinho</h1>

  <?php if (empty($produtos)): ?>
    <p class="text-center">O carrinho está vazio.</p>
    <div class="text-center">
      <a href="index.php" class="btn btn-primary">Voltar à Loja</a>
    </div>
  <?php else: ?>
    <form method="post" action="carrinho.php" class="mb-3">
      <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
          <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($produtos as $p):
              $sub = $p['preco'] * $p['quantidade'];
              $total += $sub;
          ?>
          <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td style="width:120px;">
              <input 
                type="number" 
                name="quantidade[<?= $p['id'] ?>]" 
                value="<?= $p['quantidade'] ?>" 
                min="0" 
                class="form-control"
              >
            </td>
            <td>R$ <?= number_format($sub, 2, ',', '.') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="d-flex justify-content-between align-items-center">
        <p class="h5 mb-0">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>

        <div>
          <button type="submit" name="atualizar" class="btn btn-secondary me-2">Atualizar Quantidades</button>
          <a href="finalizar.php" class="btn btn-success">Finalizar Compra</a>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
