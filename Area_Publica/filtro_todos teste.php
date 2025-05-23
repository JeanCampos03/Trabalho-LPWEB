<?php
session_start();
include('../admin/banco.php');

// Obtém o filtro da sessão (se existir)
$cat_id = $_SESSION['categoria_filtro'] ?? null;

// Monta a consulta dos produtos, filtrando por categoria se houver filtro
if ($cat_id) {
    $sql_todos = "SELECT c.id, c.nome as nome_categoria, p.nome produto_nome, p.preco produto_preco, p.id produto_id
                  FROM produtos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE c.id = $cat_id";
} else {
    $sql_todos = "SELECT c.id, c.nome as nome_categoria, p.nome produto_nome, p.preco produto_preco, p.id produto_id
                  FROM produtos p
                  JOIN categorias c ON p.categoria_id = c.id";
}

// Consulta para carregar as categorias no menu
$filtros = "SELECT DISTINCT id, nome as nome_categoria FROM categorias";

$resultado_todos = $con->query($sql_todos);
$resultado_filtros = $con->query($filtros);

// Prepara array com os produtos para facilitar o uso no HTML
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
          <a class="menu-categorias-button" href="index.php?id=<?= $linhas['id']; ?>">
            <?= htmlspecialchars($linhas['nome_categoria']); ?>
          </a>
        <?php } ?>
        <a class="menu-categorias-button" href="limpar_filtro.php">Todos</a>
      </div>
    </div>

  <div class="conteudo">

    <h2 class="titulo">
      <?php 
        if ($cat_id) {
          foreach ($resultado_filtros as $cat) {
            if ($cat['id'] == $cat_id) {
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
