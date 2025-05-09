<?php
include('../admin/banco.php');   //pedro

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

$stmt = $con->query("SELECT id, nome FROM categorias");

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

<div class = "container-login" >
    <a href="/admin/login.php" class="btn-login">Login</a>
</div>

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
