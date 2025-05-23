<?php
session_start();
include("../banco.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:/Area_Publica/index.php');
    exit;
}

if (isset($_POST['id'])) {
    $_SESSION['id_categoria_para_editar'] = $_POST['id'];
}

$id = $_SESSION['id_categoria_para_editar'] ?? null;

if (!$id) {
    echo "<h3>ID da categoria não informado.</h3>";
    echo "<a href='index.php' class='btn btn-secondary'>Voltar</a>";
    exit;
}

$sql = "SELECT * FROM categorias WHERE id = '$id'";
$result = $con->query($sql);
$categoria = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Categoria</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; padding: 40px; }
    .container-form { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 12px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
<div class="container-form">
  <h2 class="text-center mb-4">Editar Categoria</h2>
  <form action="categorias_editar_salvar.php" method="post">
    <div class="form-group">
      <label>ID:</label>
      <input type="text" name="id" class="form-control" readonly value="<?= htmlspecialchars($categoria['id']) ?>">
    </div>
    <div class="form-group">
      <label>Nome da Categoria:</label>
      <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($categoria['nome']) ?>">
    </div>
    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
  </form>
</div>
</body>
</html>
