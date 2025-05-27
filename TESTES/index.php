<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testando</title>
    <link rel="icon" type="image/png" href="/TESTES/images/images.png">

  <style>
    body {
      background-color: rgb(119, 116, 116);
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
      max-width: 900px;
      margin: 0 auto 30px auto;

    }

    .container-form {
    border-radius: 10px;
    padding: 20px;
    background-color: rgb(155, 50, 50);
    color: #fff;
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
    margin: 0 auto 30px auto;
    max-width: 1000px;

    }

    .cartao {
      width: 250px;
      background-color: #fff;
      border-radius: 8px;
      padding: 15px;
      
    }

    .cartao:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 20px rgb(240, 58, 58);
    }

    
  </style>

  </head>
<body>

<div class="container-form">
  <div class = "form">

    <form method="post" action="/TESTES/index.php">

      <label> Id :</label>
      <input type="number" name="id">

      <label> Nome :</label>
      <input type="text" name="nome"> 

      <label> Idade :</label>
      <input type="number" name="idade">

      <label> E-mail :</label>
      <input type="text" name="email">

      <button class="btn">Salvar</button>

    </form>
  </div>
</div>

<?php
//Consulta com o banco de dados e validação de resultados

    $conection = new mysqli("localhost", "root", "", "teste_jean");

    $consulta = "SELECT * FROM usuario";

    $resultado_consulta = $conection->query($consulta);

    $usuarios = [];
  

    if ($resultado_consulta && $resultado_consulta->num_rows > 0) {
    foreach ( $resultado_consulta as $linha ) {
      $usuarios[] = $linha;
    }
   
      
    }
    
     
?>

  <!-- Exibição dos perfis em cards-->
  <div class='container' >
    <?php  foreach ($usuarios as $usuario) { ?>
      <div class='cartao' >
        <p><strong> Id :</strong> <?php echo $usuario['id_usuario'];  ?> </p> 
        <p><strong> Nome :</strong> <?php echo $usuario['nome'];  ?></p>
        <p><strong> Idade :</strong> <?php echo $usuario['idade'];  ?> </p>
        <p><strong> E-mail :</strong> <?php echo $usuario['email']; ?>  </p>
      </div> 

    <?php } ?>

  </div>

</body>
</html>