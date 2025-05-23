<?php 
session_start();
include('../admin/banco.php');

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    $id = (int) $_GET['add'];

    
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]++;
    } else {
        $_SESSION['carrinho'][$id] = 1;
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

if (isset($_POST['voltar'])) {
    unset($_SESSION['carrinho']); ;
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; color: #333; }
    h1 { text-align: center; margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); overflow: hidden; }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
    th { background-color: #f7f7f7; font-weight: bold; }
    tr:last-child td { border-bottom: none; }
    .total { font-size: 1.2em; font-weight: bold; margin-top: 20px; text-align: right; }
    .botao { background-color: #9333ea; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-size: 1em; cursor: pointer; margin-top: 20px; float: right; transition: background-color 0.3s; }
    .botaoVoltar { background-color: #9333ea; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-size: 1em; cursor: pointer; margin-top: 20px; float: left; transition: background-color 0.3s; }
    .botaoContinua { background-color: #9333ea; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-size: 1em; cursor: pointer; }
    .botao:hover { background-color: #7a26c2; }
  </style>
</head>
<body>

<button class="botaoContinua" onclick="window.location.href='index.php'">Continuar comprando</button>
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
        <input type="hidden" name="produto_id[]" value="<?= $p['id'] ?>">
        <input type="hidden" name="quantidade[]" value="<?= $p['quantidade'] ?>">
      </tr>
      <?php endforeach; ?>
    </table>
    <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
    <button type="submit" class="botao">Finalizar Compra</button>    
  </form> 
  <form method="post">
    <button type="submit" name="voltar" class="botaoVoltar">Limpar carrinho</button>
  </form> 

<?php endif; ?>

</body>
</html>

