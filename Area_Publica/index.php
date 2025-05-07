<?php
include('C:\xampp\htdocs\admin\banco.php');

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
      
   <link rel="icon" type="image/png" href="/images/bolatitle.png">
   <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="/admin/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="/admin/css/style.css">
 
   </head>
   <body>

   <div class= "container p-2" >
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <div style="display: flex;">
   <ul style="margin-left: auto;">
         <a href="/admin/login.php" class="btn btn-success"> Logar </a>
   </ul>
   </div>
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