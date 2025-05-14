<!DOCTYPE html>
<html lang="pt-BR">
<title>Fut Camisas</title>
<link rel="icon" type="image/png" href="/images/title.png">

<?php
include ('../banco.php');

$categoria_id = $_POST['idcategoria'];
$categoria_nome = $_POST['categorianome'];


if ($categoria_id == '' || $categoria_nome == '') {
        echo "Erro - Não pode haver valores nulos";
        
} else {
        $sql_id = "SELECT * FROM CATEGORIAS 
           WHERE id = '$categoria_id'";

        $sql_nome = "SELECT * FROM CATEGORIAS 
           WHERE nome = '$categoria_nome'";

        $con->query($sql_id);
        $con->query($sql_nome);


        $resultado_id = $con->query($sql_id);
        $resultado_nome = $con->query($sql_nome);

        if (mysqli_num_rows($resultado_id) > 0 || mysqli_num_rows($resultado_nome ) > 0) {
                echo "id ou categoria já existe!";
        } else  {

        $sql_create = "INSERT INTO categorias (id, nome) 
        VALUES ('$categoria_id', '$categoria_nome')";

        $con->query($sql_create);
        header('location:/admin/categorias/index.php');
        }
        }

?>

<a href="/admin/categorias/index.php" class="btn btn-primary"> Tentar Novamente </a>
</html>

--------------


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Salvar Categoria</title>
  <link rel="icon" type="image/png" href="/images/title.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      padding: 40px;
    }
    .container-form {
      max-width: 600px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0px 0px 12px rgba(0,0,0,0.1);
    }
    .erro {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="container-form">
<?php
include ('../banco.php');

$categoria_id = $_POST['idcategoria'];
$categoria_nome = $_POST['categorianome'];

if ($categoria_id == '' || $categoria_nome == '') {
    echo "<h2 class='erro'>Erro - Não pode haver valores nulos</h2>";
    echo "<a href='/admin/categorias/index.php' class='btn btn-warning mt-3'>Tentar Novamente</a>";
} else {
    $sql_id = "SELECT * FROM CATEGORIAS WHERE id = '$categoria_id'";
    $sql_nome = "SELECT * FROM CATEGORIAS WHERE nome = '$categoria_nome'";

    $resultado_id = $con->query($sql_id);
    $resultado_nome = $con->query($sql_nome);

    if (mysqli_num_rows($resultado_id) > 0 || mysqli_num_rows($resultado_nome) > 0) {
        echo "<h2 class='erro'>ID ou categoria já existe!</h2>";
        echo "<a href='/admin/categorias/index.php' class='btn btn-warning mt-3'>Tentar Novamente</a>";
    } else {
        $sql_create = "INSERT INTO categorias (id, nome) VALUES ('$categoria_id', '$categoria_nome')";
        $con->query($sql_create);
        header('location:/admin/categorias/index.php');
    }
}
?>
</div>
</body>
</html>
