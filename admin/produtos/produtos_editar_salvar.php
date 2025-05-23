<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
  header('location:/Area_Publica/index.php');
  exit;
}

include("../banco.php");

$id = trim($_POST["id"] ?? '');
$nome = trim($_POST["nome"] ?? '');
$preco = trim($_POST["preco"] ?? '');
$categoria_id = trim($_POST["categoria_id"] ?? '');

if ($id === '' || $nome === '' || $preco === '' || $categoria_id === '') {
  ?>
  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <title>Erro ao salvar</title>
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
      .erro {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
  <div class="container-form">
    <h2 class="erro">Todos os campos são obrigatórios.</h2>
    <a href="/admin/produtos/index.php" class="btn btn-warning mt-3">Tentar Novamente</a>
  </div>
  </body>
  </html>
  <?php
  exit;
}

$sql = "UPDATE produtos 
        SET nome = '$nome', preco = '$preco', categoria_id = '$categoria_id'
        WHERE id = '$id'";

$con->query($sql);

header("Location: /admin/produtos/index.php");
exit;
?>
