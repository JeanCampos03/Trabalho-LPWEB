<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode
 simplesmente não fazer o login e digitar na barra de endereço do seu navegador
o caminho para a página principal do site (sistema), burlando assim a obrigação de
fazer um login, com isso se ele não estiver feito o login não será criado a session,
então ao verificar que a session não existe a página redireciona o mesmo
 para a index.php.*/
session_start();
if(!isset ($_SESSION['usuario']) && !isset ($_SESSION['senha']))
{
  header('location:/Area_Publica/index.php');
}

include('../admin/banco.php');

$logado = $_SESSION['usuario'];


// Destaques (os 3 mais vendidos)
$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC
                  LIMIT 10";
                  
$resultado_destaques = $con->query($sql_destaques);

$destaques = [];
if ($resultado_destaques && $resultado_destaques->num_rows > 0) {
    foreach ($resultado_destaques as $linha) {
        $destaques[] = $linha;
    }
}

// Todos os produtos
$sql_todos = "SELECT id, nome, preco FROM produtos";
$resultado_todos = $con->query($sql_todos);

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
  <title> FUT CAMISAS</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="container">
  <div class="d-flex">
    <span>Seja bem-vindo(a) <?php echo $logado; ?></span>
    <a href="logout.php" class="btn-logout">Logout</a>
  </div>
</div>


  <header class="topo">
    <h1>DASHBOARD</h1>
    <nav>
      <ul class="menu">
            <li><a href="categorias\index.php">Categorias</a></li>
            <li><a href="produtos\index.php">Produtos</a></li>
            <li><a href="vendas\index.php">Vendas</a></li>
      </ul>
    </nav>
    
  </header>

  <section class="produtos-section">
    <h2 class="titulo">TOP 10 MAIS VENDIDOS</h2>
    <div class="produtos-grid">
  <?php if (count($destaques) > 0): ?>
    <?php foreach ($destaques as $produto): ?>
      <div class="produto">
        <img src="/images/<?php echo $produto['id']; ?>.png" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>
        <p class="preco">R$ <?php echo number_format($produto['preco'], 1, ',', '.'); ?></p>
        <!---<a href="#">Comprar</a>-->
        <a href="compra.php?id=<?php echo $produto['id']; ?>">Comprar</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nenhum destaque disponível.</p>
  <?php endif; ?>
</div>

</body>
</html>
