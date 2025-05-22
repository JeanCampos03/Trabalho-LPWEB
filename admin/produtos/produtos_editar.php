<?php
include("../banco.php");
session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true)) {
  header('location:/Area_Publica/index.php');
}

$logado = $_SESSION['usuario'];
$id = @$_GET["id"];

$sql = "SELECT p.*, c.nome nome_categoria 
        FROM produtos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = $id";



$resultado = $con->query($sql);
$dados = mysqli_fetch_assoc($resultado);


$t = "SELECT DISTINCT id,nome FROM categorias";
$resultT = $con->query($t);



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Produto <?= $dados["id"] ?></title>
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
      box-shadow: 0px 0px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="container-form">
    <h2 class="text-center">Editar Produto</h2>
    <form action="produtos_editar_salvar.php" method="post">
      <div class="form-group">
        <label>ID:</label>
        <input type="text" name="id" class="form-control" readonly value="<?php echo $dados["id"] ?>">
      </div>
      <div class="form-group">
        <label>Nome do Produto:</label>
        <input type="text" name="nome" class="form-control" value="<?php echo $dados["nome"]; ?>">
      </div>
      <div class="form-group">
        <label>Preço:</label>
        <input type="text" name="preco" class="form-control" value="<?php echo $dados["preco"]; ?>">
      </div>
      <div class="form-group">
        <label>ID Categoria:</label>
        <select name="categoria_id" class="form-control">
          <?php foreach ($resultT as $value) { ?>
        <option value="<?php echo $value['id'];?>"> <?php echo $value['nome'] ; ?></option>
        <?php } ?>
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
