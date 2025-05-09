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


$consulta_produtos1 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 1";

$consulta_produtos2 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 2";

$consulta_produtos3 = "SELECT NOME,PRECO 
                       FROM PRODUTOS 
                       WHERE ID = 3";

$resultado1 = $con-> query($consulta_produtos1);
$resultado2 = $con-> query($consulta_produtos2);
$resultado3 = $con-> query($consulta_produtos3);

foreach ($resultado1 as $linha1);
foreach ($resultado2 as $linha2);
foreach ($resultado3 as $linha3);


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
    <h1>Destaques</h1>
    <nav>
      <ul class="menu">
            <li><a href="categorias\index.php">Categorias</a></li>
            <li><a href="produtos\index.php">Produtos</a></li>
            <li><a href="vendas\index.php">Vendas</a></li>
      </ul>
    </nav>
    
  </header>

  <section class="produtos-section">
    <h2 class="titulo">Destaques</h2>
    <div class="produtos-container">
      <div class="produto">
        <img src="/images/palmeiras.png" alt="Produto 1">
        <h3> <?php echo $linha2['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha2['PRECO']; ?> </p>
        <a href="#">Comprar</a>
      </div>

      <div class="produto">
        <img src="/images/spfc.png" alt="Produto 2">
        <h3> <?php echo $linha1['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha1['PRECO']; ?></p>
        <a href="#">Comprar</a>
      </div>

      <div class="produto">
        <img src="/images/sccp.png" alt="Produto 3">
        <h3> <?php echo $linha3['NOME'] ?> </h3>
        <p class="preco"><span>Preço: R$</span> <?php echo $linha3['PRECO']; ?> </p>
        <a href="#">Comprar</a>
      </div>
    </div>
  </section>


</body>
</html>
