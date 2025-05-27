<?php 
include("banco.php");

$sql = "SELECT * FROM USUARIO";

$con->query($sql);

$resultado = $con->query($sql);

if (mysqli_num_rows($resultado) != 1 ) {
    header('location:login_novo.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Login Admin</title>
    <link rel="icon" type="image/png" href="/images/title.png">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="container-login-admin">
    <form class="form-login-admin" action="sessao_inicia.php" method="post">
        <legend>LOGIN</legend><br />
        
        <span> USUÁRIO : </span>
        <input type="text" name="usuario" /><br>        
        
        <span> SENHA : </span>
        <input type="password" name="senha" /><br><br>

        <a href="/Area_Publica/index.php" class="btn input-login-admin">Voltar</a>
        <input type="submit" value="Logar" class="btn input-login-admin" />
    </form>
</div>

</body>
</html>