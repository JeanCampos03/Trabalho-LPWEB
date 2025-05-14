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
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fafafa;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f7f7f7;
      font-weight: bold;
    }

    tr:last-child td {
      border-bottom: none;
    }

    input[type="hidden"] {
      display: none;
    }

    .total {
      font-size: 1.2em;
      font-weight: bold;
      margin-top: 20px;
      text-align: right;
    }

    .botao {
      background-color: #9333ea;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-size: 1em;
      cursor: pointer;
      margin-top: 20px;
      float: right;
      transition: background-color 0.3s;
    }

    .botao:hover {
      background-color: #7a26c2;
    }

    p {
      margin: 10px 0;
    }

    a {
      color: purple;
      text-decoration: underline;
    }

    input[type="number"], .quantidade {
      width: 60px;
      text-align: center;
    }

    .quantidade-btn {
      display: inline-block;
      width: 28px;
      height: 28px;
      text-align: center;
      line-height: 26px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #fff;
      cursor: pointer;
      font-weight: bold;
      margin: 0 5px;
    }

    .checkbox {
      margin-top: 10px;
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
<?php endif; ?>

</body>
</html>


