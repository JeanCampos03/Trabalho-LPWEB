<?php
session_start();
include('../admin/banco.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $_SESSION['categoria_filtro'] = (int) $_GET['id'];
} elseif (isset($_GET['limpar_filtro'])) {
    unset($_SESSION['categoria_filtro']);
}

if (isset($_SESSION['categoria_filtro'])) {
    $cat_id = $_SESSION['categoria_filtro'];
    $sql_todos = "SELECT c.id, c.nome as nome_categoria, p.nome produto_nome, p.preco produto_preco, p.id produto_id
                  FROM produtos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE c.id = $cat_id";
} else {
    $sql_todos = "SELECT c.id, c.nome as nome_categoria, p.nome produto_nome, p.preco produto_preco, p.id produto_id
                  FROM produtos p
                  JOIN categorias c ON p.categoria_id = c.id";
}

$filtros = "SELECT DISTINCT id, nome as nome_categoria FROM categorias ORDER BY nome_categoria";
$resultado_todos = $con->query($sql_todos);
$resultado_filtros = $con->query($filtros);

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
  <title>Fut Camisas | Área Pública</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="container-login">
  <a href="/admin/login.php" class="btn btn-login">Login</a>
</div>

<div class="layout">

    <div class="menu-categorias">
      <h3>Categorias</h3>
      <div class="produtos-grid">
        <?php foreach ($resultado_filtros as $linhas) { ?>
          <a class="menu-categorias-button" href="index.php?id=<?= $linhas['id']; ?>">
            <?= htmlspecialchars($linhas['nome_categoria']) ?>
          </a>
        <?php } ?>
        <a class="menu-categorias-button" href="index.php?limpar_filtro=1">Todos</a>
      </div>
    </div>

  <div class="conteudo">

    <h2 class="titulo"> 
      <?php 
        if (isset($_SESSION['categoria_filtro'])) {          
          foreach ($resultado_filtros as $cat) {
            if ($cat['id'] == $_SESSION['categoria_filtro']) {
              echo "Categoria: " . htmlspecialchars($cat['nome_categoria']);
              break;
            }
          }
        } else {
          echo "Todos os produtos";
        }
      ?>
    </h2>

    <div class="produtos-grid">
      <?php if (count($produtos) > 0): ?>
        <?php foreach ($produtos as $produto): ?>
          <div class="produto">
            <img src="/images/<?= $produto['produto_id']; ?>.png" alt="<?= htmlspecialchars($produto['produto_nome']); ?>">
            <h3><?= htmlspecialchars($produto['produto_nome']); ?></h3>
            <p class="preco">R$ <?= number_format($produto['produto_preco'], 2, ',', '.'); ?></p>
            <a href="compra.php?id=<?= $produto['produto_id']; ?>">Comprar</a>
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
