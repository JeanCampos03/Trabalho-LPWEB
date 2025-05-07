<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <title>CADASTRAR</title>
    <link rel="icon" type="image/png" href="/images/bolatitle.png">

</head>

<body>
    <form action="cadastrar_produto_salvar.php" method="post">
        <legend>CADASTRO DE PRODUTOS</legend><br />
        
        <div>
            <label for="email">ID DO PRODUTO :</label>
            <input type="text" name="idproduto"> <br> <br>

            <label for="email">DESCRIÇÃO : </label>
            <input type="text" name="descricao"> <br> <br>

            <label for="email">PREÇO :</label>
            <input type="text" name="preco"> <br> <br>

            <label for="email">ID CATEGORIA :</label>
            <input type="text" name="idcategoria"> <br> <br>

        </div>

        <div>

            <a href="index.php" class="btn btn-primary"> Voltar </a>

            <input type="submit" value="Cadastrar" class="btn btn-primary" />
        </div>
    </form>
</body>

</html>