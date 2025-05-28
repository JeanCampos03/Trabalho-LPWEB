<?php
include("../banco.php");
session_start();

if ((!isset($_SESSION['usuario']) == true) && (!isset($_SESSION['senha']) == true)) {
    header('location:/Area_Publica/index.php');
}

$t = "SELECT DISTINCT id, nome FROM categorias";
$resultT = $con->query($t);

$form = $_SESSION['form_data'] ?? [    
    'descricao' => '',
    'preco' => '',
    'categoria_id' => ''
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>CADASTRAR PRODUTO</title>
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
    <h1 class="text-center">Cadastro de Produtos</h1>

    <?php if (isset($_SESSION['error_message'])): ?> <!-- Exibe mensagem de erro-->
      <div class="alert alert-danger">
        <?= $_SESSION['error_message'] ?>
        <?php unset($_SESSION['error_message']); ?>
      </div>
    <?php endif; ?>

    <form action="produtos_cadastrar_salvar.php" method="post">      

      <div class="form-group">
        <label>Descrição:</label>
        <input type="text" name="descricao" class="form-control" value="<?= htmlspecialchars($form['descricao']) ?>">
      </div>

      <div class="form-group">
        <label>Preço:</label>
        <input type="text" name="preco" class="form-control" value="<?= htmlspecialchars($form['preco']) ?>">
      </div>

      <div class="form-group">
        <label>Categoria:</label>
        <select name="categoria_id" class="form-control">
          <option value="">Selecione uma categoria</option>
          <?php foreach ($resultT as $value): ?>
            <option value="<?= $value['id'] ?>"
              <?= $form['categoria_id'] == $value['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($value['nome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
        <input type="submit" value="Cadastrar" class="btn btn-primary">
      </div>
    </form>
  </div>
</body>
</html>
