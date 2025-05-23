<?php
session_start();
include('../admin/banco.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produto inválido.";
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = $id";
$resultado = $con->query($sql);

if (!$resultado || $resultado->num_rows == 0) {
    echo "Produto não encontrado.";
    exit;
}

$produto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qtd = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] += $qtd;
    } else {
        $_SESSION['carrinho'][$id] = $qtd;
    }

    header("Location: carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?php echo $produto['nome']; ?> - FUT CAMISAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <img src="/images/<?php echo strtolower($produto['id']); ?>.png" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
          <p class="card-text"><strong>Preço:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>

          <form method="post">
            <div class="mb-3">
              <label for="quantidade" class="form-label">Quantidade</label>
              <input type="number" name="quantidade" id="quantidade" class="form-control" value="1" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Adicionar ao Carrinho</button>
          </form>

          <div class="mt-3 text-center">
            <a href="index.php" class="btn btn-secondary">Voltar a loja</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
