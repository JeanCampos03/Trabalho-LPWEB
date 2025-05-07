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

include("banco.php");

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
<html lang="pt-br">
<head>
  <!-- basic -->
  
  <title>Fut Camisas</title>
  <link rel="icon" type="image/png" href="\images\bolatitle.png">
  <!-- bootstrap css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  
</head>

<body>

  <div class="container">
    <div class="d-flex justify-content-between align-items-center p-2">
      <span>Seja bem-vindo(a) <?php echo $logado; ?> </span>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>

  <!--aplica estilos próprios para a parte de cima do cabeçalho (como altura, cor, fonte, espaçamento, etc.). -->
  <div class="row">
    <div class="header_section_top">
      <div class="banner_bg_main"> <!--menu personalizado, estilizado com CSS -->
        <div class="custom_menu"> 
          <ul>
            <li><a href="categorias\index.php">Categorias</a></li>
            <li><a href="produtos\index.php">Produtos</a></li>
            <li><a href="vendas\index.php">Vendas</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- fashion section start -->
  <h1 class="fashion_taital">Destaques</h1>


  <div class='container'>
    <div class='fashion_section_2'>
      <div class='row'>
        <div class='col-lg-4 col-sm-4'>
          <div class='box_main'>
            <h4 class='shirt_text'> <?php echo $linha2['NOME'] ?> </h4>
            <p class='price_text'>Preço : <span style='color:#262626;'> <?php echo $linha2['PRECO']; ?> </span></p>
            <div class='tshirt_img'><img src='/images/palmeiras.png'></div> 
            <div class='btn_main'>
              <div class='seemore_bt'><a href='#'>Comprar</a></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="box_main">
            <h4 class="shirt_text"> <?php echo $linha1['NOME'] ?> </h4>
            <p class="price_text">Preço : <span style="color:#262626;"> <?php echo $linha1['PRECO']; ?></span></p>
            <div class="tshirt_img"><img src="/images/spfc.png"></div>
            <div class="btn_main">
              <div class="seemore_bt"><a href="#">Comprar</a></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="box_main">
            <h4 class="shirt_text"> <?php echo $linha3['NOME'] ?> </h4>
            <p class="price_text">Preço : <span style="color:#262626;"> <?php echo $linha3['PRECO']; ?> </span></p>
            <div class="tshirt_img"><img src="/images/sccp.png"></div>
            <div class="btn_main">
              <div class="seemore_bt"><a href="#">Comprar</a></div>
            </div>
          </div>
        </div>
      </div>
    </div> 
  </div>

</body>
</html>
