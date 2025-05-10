<?php
include('../admin/banco.php'); 

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
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <link rel="stylesheet" href="/css/styles.css">
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
<?php endif; ?>

</body>
</html>