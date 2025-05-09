<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <title>SEM CADASTRO </title>
    <link rel="icon" type="image/png" href="\images\title.png">

</head>

<body>
    <form action="login_novo_salvar.php" method="post">
        <h1>ERRO-LOGIN NAO ENCONTRADO </h1>
        <legend>CRIE UM LOGIN</legend><br />
        <div>
            <span> USUÁRIO : </span>
            <input type="text" name="usuario" />
        </div>

        <br>

        <div> <!--div é como se fosse um coringa é invisivel ao olho nu, mas conseguimos dar formato a ela.-->
            <span> SENHA : </span>
            <input type="password" name="senha" />
        </div>


        <div>

            <a href="login.php" class="btn btn-danger"> Tentar Novamente </a>

            <input type="submit" value="Criar" class="btn btn-primary" />
        </div>
    </form>
</body>

</html>