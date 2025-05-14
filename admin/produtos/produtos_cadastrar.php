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
    <form action="produtos_cadastrar_salvar.php" method="post">
      <div class="form-group">
        <label>ID do Produto:</label>
        <input type="text" name="idproduto" class="form-control">
      </div>
      <div class="form-group">
        <label>Descrição:</label>
        <input type="text" name="descricao" class="form-control">
      </div>
      <div class="form-group">
        <label>Preço:</label>
        <input type="text" name="preco" class="form-control">
      </div>
      <div class="form-group">
        <label>ID Categoria:</label>
        <input type="text" name="idcategoria" class="form-control">
      </div>
      <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
        <input type="submit" value="Cadastrar" class="btn btn-primary">
      </div>
    </form>
  </div>
</body>
</html>
