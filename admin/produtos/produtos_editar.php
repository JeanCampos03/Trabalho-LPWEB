<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
  exit;
}

$logado = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $_SESSION['id_produto_para_editar'] = $_POST['id'];
}

$id = $_SESSION['id_produto_para_editar'] ?? null;

if (!$id) {
  echo "<h3>ID do produto não foi informado.</h3>";
  echo "<a href='/admin/produtos/index.php' class='btn btn-secondary mt-3'>Voltar</a>";
  exit;
}

$sql = "SELECT p.*, c.nome AS nome_categoria 
        FROM produtos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = '$id'";

$resultado = $con->query($sql);
$dados = mysqli_fetch_assoc($resultado);

if (!$dados) {
  echo "<h3>Produto não encontrado.</h3>";
  echo "<a href='/admin/produtos/index.php' class='btn btn-secondary mt-3'>Voltar</a>";
  exit;
}

$t = "SELECT id, nome FROM categorias ORDER BY nome";
$resultT = $con->query($t);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Alterar Produto <?= htmlspecialchars($dados["id"]) ?></title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      padding: 40px;
    }
    .container-form {
      max-width: 600px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="container-form">
    <h2 class="text-center mb-4">Editar Produto</h2>
    <form action="produtos_editar_salvar.php" method="post">
      <div class="form-group">
        <label>ID:</label>
        <input type="text" name="id" class="form-control" readonly value="<?= htmlspecialchars($dados["id"]) ?>">
      </div>
      <div class="form-group">
        <label>Nome do Produto:</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($dados["nome"]) ?>">
      </div>
      <div class="form-group">
        <label>Preço:</label>
        <input type="text" name="preco" class="form-control" value="<?= htmlspecialchars($dados["preco"]) ?>">
      </div>
      <div class="form-group">
        <label>Categoria:</label>
        <select name="categoria_id" class="form-control">
          <?php foreach ($resultT as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $dados['categoria_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/admin/produtos/index.php" class="btn btn-secondary">Voltar</a>
      </div>
    </form>
  </div>
</body>
</html>
