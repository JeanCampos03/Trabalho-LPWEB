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


// Destaques (os mais vendidos)
$sql_destaques = "SELECT produtos.id, produtos.nome, produtos.preco, SUM(vendasitens.quantidade) AS qtde
                  FROM vendasitens
                  INNER JOIN produtos ON produtos.id = vendasitens.produto_id
                  GROUP BY produtos.id, produtos.nome, produtos.preco
                  ORDER BY qtde DESC";
                  
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

$sql_conta_vendas = "SELECT vi.produto_id AS produto_id, count(vi.produto_id) AS numero_vendas_itens 
                     FROM vendasitens vi
                     JOIN vendas v ON v.id = vi.venda_id
                     GROUP BY vi.produto_id
                     ORDER BY numero_vendas_itens DESC";

$resultado_vendas = $con->query($sql_conta_vendas);

$vendas = [];
if ($resultado_vendas && $resultado_vendas->num_rows > 0) {
    foreach ($resultado_vendas as $linha) {
        $vendas[] = $linha;
    }
}

$total_vendas_valor = "SELECT sum(p.preco) total_vendas 
                 FROM produtos p
                 JOIN vendasitens vi 
                 on vi.produto_id = p.id";
$resultado_total_valor = $con->query($total_vendas_valor);

$total = [];
foreach ($resultado_total_valor as $linha) {
    $total = $linha;
}

$total_vendas_itens = "SELECT sum(id) total_itens FROM vendasitens";

$resultado_total_itens = $con->query($total_vendas_itens);

$itens = [];
foreach ($resultado_total_itens as $linha) {
  $itens = $linha;
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


  <header class="topo-dashboard">
  <h1>DASHBOARD</h1>
  <ul class="menu-detalhes">
  <li> Quantidade vendas : <?php echo $itens['total_itens']; ?></li>
  </ul>

  <ul class="menu-detalhes">
  <li>Vendas totais : R$<?php echo number_format($total['total_vendas'], 2, ',', '.');?></li>
    </ul>
      
  </header>

    <header class="topo">
    <nav>
      <ul class="menu">
            <li><a href="categorias\index.php">Categorias</a></li>
            <li><a href="produtos\index.php">Produtos</a></li>
      </ul>
    </nav>
    
  </header>

  <section class="produtos-section">
    <h2 class="titulo">TOP 10 MAIS VENDIDOS</h2>
    <div class="produtos-grid">
  <?php if (count($destaques) > 0): ?>
    <?php foreach ($destaques as $produto): 
      $conta_vendas = 0; ?>
      
      <?php foreach ($vendas as $vendas_prod) {
      if ($vendas_prod['produto_id'] == $produto['id']) {
        $conta_vendas = $vendas_prod['numero_vendas_itens'];
        break;
      }} ?>

      <div class="produto">
        <img src="/images/<?php echo $produto['id']; ?>.png" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>        
        <p class="preco">R$ <?php echo number_format($produto['preco'], 1, ',', '.'); ?></p>
        <p class="preco">Id produto : <?php echo $produto['id']; ?></p>
        <p class="preco">Vendidos : <?php echo $conta_vendas?></p>

      </div>

    <?php endforeach; ?>
  <?php else: ?>
    <p>Nenhuma venda ainda</p>
  <?php endif; ?>
</div>

</body>
</html>
