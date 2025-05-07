<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <title>PRODUTOS</title>
    <link rel="icon" type="image/png" href="/images/bolatitle.png">

</head>

<body>
    <form action="cadastrar_categoria.php" method="post">
        <legend>CADASTRO DE CATEGORIAS</legend><br />
        <div>
            <span> ID CATEGORIA : </span>
            <input type="text" name="idcategoria" />

            
        </div>

        <br>

        <div> <!--div é como se fosse um coringa é invisivel ao olho nu, mas conseguimos dar formato a ela.-->
            <span> NOME CATEGORIA : </span>
            <input type="text" name="categorianome" />
        </div>

        <div>

            <a href="/admin/dashboard.php" class="btn btn-primary"> Voltar </a>

            <input type="submit" value="Cadastrar" class="btn btn-primary" />
        </div>
    </form>
</body>

</html>