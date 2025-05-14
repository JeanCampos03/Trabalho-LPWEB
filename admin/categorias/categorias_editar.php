<?php
include("../banco.php");
session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true)) {
  header('location:/Area_Publica/index.php');
}

$logado = $_SESSION['usuario'];
$id = @$_GET["id"];

$sql = "SELECT * FROM categorias WHERE id = $id";
$resultado = $con->query($sql);
$dados = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Categoria <?= $dados["id"] ?></title>
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
    <h2 class="text-center">Editar Categoria</h2>
    <form action="categorias_editar_salvar.php" method="post">
      <div class="form-group">
        <label>ID:</label>
        <input type="text" name="id" class="form-control" readonly value="<?= $dados["id"] ?>">
      </div>
      <div class="form-group">
        <label>Nome da Categoria:</label>
        <input type="text" name="nome" class="form-control" value="<?= $dados["nome"] ?>">
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/admin/categorias/index.php" class="btn btn-secondary">Voltar</a>
      </div>
    </form>
  </div>
</body>
</html>
