<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>LOGIN ADM</title>
    <link rel="icon" type="image/png" href="\images\title.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>



<body><!-- deixa o form centralizado -->
    <style>
        form { 
            text-align: center;          
        }
        input { 
            text-align: center;          
        }
        
    </style>
    <form action="sessao_inicia.php" method="post">
        <legend>LOGIN</legend><br />
        <div>
            <span> USUÁRIO : </span>
            <input type="text" name="usuario" />
        </div>
        <br>

        <div> <!--div é como se fosse um coringa é invisivel ao olho nu, mas conseguimos dar formato a ela.-->
            <span> SENHA : </span>
            <input type="password" name="senha" />
        </div>

        <div class="text-center mt-3">  <!--Separa os botoes adicionando margem acima-->
        <a href="\Area_Publica\index.php" class="btn btn-primary center me-3">Voltar</a>
            <input type="submit" value="Logar" class="btn btn-primary" />
        </div>

    </form>
</body>

</html>