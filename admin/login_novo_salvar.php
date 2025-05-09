<!DOCTYPE html>
<html lang="pt-BR">
<title>Fut Camisas</title>
<link rel="icon" type="image/png" href="/images/title.png">

<?php
include("banco.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

if ($usuario == '' || $senha == '') {
        echo "Erro - Usuário ou senha nao pode ser nulo";
        
        
} else {
        $sql = "SELECT * FROM USUARIO 
        WHERE NOME = '$usuario' 
        AND SENHA = '$senha' ";

        $con->query($sql);

        $resultado = $con->query($sql);

        if (mysqli_num_rows($resultado) > 0) {
                echo "Usuário já existe!";
                
        } else  {
        $sql_create = "INSERT INTO USUARIO
        (NOME, SENHA) 
        VALUES ('$usuario', '$senha' )";

        $con->query($sql_create);
        header('location:login.php');
        }
        }

?>

<a href="login_novo.php" class="btn btn-primary"> Tentar Novamente </a>
</html>