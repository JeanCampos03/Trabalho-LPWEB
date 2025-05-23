<?php
session_start();
include('../admin/banco.php');

if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}

if (!isset($_SESSION['id'])) {
    header('location:/Area_Publica/filtro_todos.php');
    exit;
}

$id = $_SESSION['id'];

$filtros = "SELECT DISTINCT id, nome as nome_categoria FROM categorias";

$sql_todos = "SELECT c.id, c.nome as nome_categoria, p.nome produto_nome, p.preco produto_preco, p.id produto_id
              FROM produtos p
              JOIN categorias c ON p.categoria_id = c.id
              WHERE c.id = '$id'";

$titulo_h = "SELECT DISTINCT id, nome as nome_categoria
             FROM categorias
             WHERE id = '$id'";

$resultado_todos = $con->query($sql_todos);
$resultado_filtros = $con->query($filtros);
$resultado_h = $con->query($titulo_h);

$produtos = [];
if ($resultado_todos && $resultado_todos->num_rows > 0) {
    foreach ($resultado_todos as $linha) {
        $produtos[] = $linha;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>FUT CAMISAS</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="container-login">
    <a href="/admin/login.php" class="btn-login">Login</a>
</div>

<div class="layout">

    <div class="menu-categorias">
      <h3>Categorias</h3>
      <div class="produtos-grid">
        <?php foreach ($resultado_filtros as $linhas) { ?>
          <a class="menu-categorias-button" href="index.php?id=<?php echo $linhas['id']; ?>">
            <?php echo $linhas['nome_categoria']; ?>
          </a>
        <?php } ?>
        <a class="menu-categorias-button" href="filtro_todos.php">Todos</a>
      </div>
    </div>

    <div class="conteudo">
      <?php foreach ($resultado_h as $linha) { ?>
        <h2 class="titulo">Filtrando por <?php echo $linha['nome_categoria']; ?></h2>
      <?php } ?>

      <div class="produtos-grid">
        <?php if (count($produtos) > 0): ?>
          <?php foreach ($produtos as $produto): ?>
            <div class="produto">
              <img src="/images/<?php echo $produto['produto_id']; ?>.png" alt="<?php echo $produto['produto_nome']; ?>">
              <h3><?php echo $produto['produto_nome']; ?></h3>
              <p class="preco">R$ <?php echo number_format($produto['produto_preco'], 2, ',', '.'); ?></p>
              <a href="compra.php?id=<?php echo $produto['produto_id']; ?>">Comprar</a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Nenhum produto cadastrado.</p>
        <?php endif; ?>
      </div>
    </div>

</div>
</body>
</html>
