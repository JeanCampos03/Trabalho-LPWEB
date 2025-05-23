<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:/Area_Publica/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Criar Categoria</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; padding: 40px; }
    .container-form { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 12px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <div class="container-form">
    <h2 class="text-center mb-4">Nova Categoria</h2>
    <form action="cadastrar_categoria_salvar.php" method="post">
      <div class="form-group">
        <label>Nome da Categoria:</label>
        <input type="text" name="nome_categoria" class="form-control" required>
      </div>
      <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-success">Cadastrar</button>
      </div>
    </form>
  </div>
</body>
</html>
