<!DOCTYPE html>
<html lang="pt-BR">
<title>Fut Camisas</title>
<link rel="icon" type="image/png" href="/images/bolatitle.png">

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