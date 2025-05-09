<?php
include('../admin/banco.php');  #pedro

if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    $id = (int) $_GET['add'];
    $qtd = 1;

    
    echo '<form id="autoform" method="post" action="carrinho.php">';
    echo '<input type="hidden" name="produto_id[]" value="' . $id . '">';
    echo '<input type="hidden" name="quantidade[]" value="' . $qtd . '">';
    echo '</form>';
    echo '<script>document.getElementById("autoform").submit();</script>';
    exit;
}

$produtos = [];
if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
    $ids = $_POST['produto_id'];
    $qtds = $_POST['quantidade'];
    
    $valid_ids = array_filter($ids, 'is_numeric');
    if (!empty($valid_ids)) {
        $idlist = implode(",", $valid_ids);
        $query = "SELECT * FROM produtos WHERE id IN ($idlist)";
        $result = $con->query($query);

        while ($linha = $result->fetch_assoc()) {
            $i = array_search($linha['id'], $ids);
            $linha['quantidade'] = (int) $qtds[$i];
            $produtos[] = $linha;
        }

session_start();
include('../admin/banco.php');

// Inicia o carrinho se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar produto ao carrinho
if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    $id = (int) $_GET['add'];

    $busca = $con->query("SELECT * FROM produtos WHERE id = $id");
    if ($busca && $busca->num_rows > 0) {
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]++;
        } else {
            $_SESSION['carrinho'][$id] = 1;
        }
    }

    header('Location: carrinho.php');
    exit;
}

// Remover item
if (isset($_GET['remover']) && is_numeric($_GET['remover'])) {
    $id = (int) $_GET['remover'];
    unset($_SESSION['carrinho'][$id]);
    header('Location: carrinho.php');
    exit;
}

// Buscar produtos do carrinho
$produtos = [];

if (!empty($_SESSION['carrinho'])) {
    $ids = implode(",", array_keys($_SESSION['carrinho']));
    $query = "SELECT * FROM produtos WHERE id IN ($ids)";
    $result = $con->query($query);
    while ($linha = $result->fetch_assoc()) {
        $linha['quantidade'] = $_SESSION['carrinho'][$linha['id']];
        $produtos[] = $linha;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; margin-bottom: 30px; }
    th, td { border: 1px solid #ccc; padding: 12px; text-align: left; }
    th { background-color: #f0f0f0; }
    .total { font-size: 18px; font-weight: bold; text-align: right; }
    a.botao { padding: 8px 16px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; }

    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 700px;
      margin-bottom: 30px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    .total {
      font-size: 18px;
      font-weight: bold;
      text-align: right;
    }
    a.botao {
      padding: 8px 16px;
      background: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
    a.remover {
      color: red;
      text-decoration: none;
    }
  </style>
</head>
<body>

<h1>Seu Carrinho</h1>

<?php if (empty($produtos)): ?>
  <p>O carrinho está vazio.</p>
<?php else: ?>
  <form action="finalizar.php" method="post">
    <table>
      <tr>
        <th>Produto</th>
        <th>Preço</th>
        <th>Qtd</th>
        <th>Subtotal</th>
      </tr>
      <?php
      $total = 0;
      foreach ($produtos as $p):
          $sub = $p['preco'] * $p['quantidade'];
          $total += $sub;
      ?>
      <tr>
        <td><?= $p['nome'] ?></td>
        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
        <td><?= $p['quantidade'] ?></td>
        <td>R$ <?= number_format($sub, 2, ',', '.') ?></td>
        <!-- Campos ocultos -->
        <input type="hidden" name="produto_id[]" value="<?= $p['id'] ?>">
        <input type="hidden" name="quantidade[]" value="<?= $p['quantidade'] ?>">
      </tr>
      <?php endforeach; ?>
    </table>
    <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
    <button type="submit" class="botao">Finalizar Compra</button>
  </form>

  <table>
    <tr>
      <th>Produto</th>
      <th>Preço</th>
      <th>Qtd</th>
      <th>Subtotal</th>
      <th>Ação</th>
    </tr>
    <?php
    $total = 0;
    foreach ($produtos as $p):
        $sub = $p['preco'] * $p['quantidade'];
        $total += $sub;
    ?>
    <tr>
      <td><?= $p['nome'] ?></td>
      <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
      <td><?= $p['quantidade'] ?></td>
      <td>R$ <?= number_format($sub, 2, ',', '.') ?></td>
      <td><a href="?remover=<?= $p['id'] ?>" class="remover">Remover</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
  <a href="finalizar.php" class="botao">Finalizar Compra</a>
<?php endif; ?>

</body>
</html>
