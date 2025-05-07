<?php

include("../banco.php");
session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true))
{
  header('location:in/Area_Publica/index.php');
  }

$logado = $_SESSION['usuario'];
/* 
**   http://localhost/outros/aluno_alterar.php?ra=55555
**   colocou link é GET, pois vai na URL;
**   1- Receber via GET o RA do aluno.
**   
**   2- Buscar aluno no banco de dados.
**
**   3- Iremos mostrar os dados dele na tela dentro do form 
**
**   4- Enviar os dados alterados para o servidor salvar
*/

$id = @$_GET["id"];

//echo $ra;

$sql = "SELECT p.*, c.nome nome_categoria 
                    FROM produtos p
                    JOIN categorias c
                    ON p.categoria_id = c.id
                    WHERE p.id = $id";

$resultado = $con-> query($sql);

$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        
    Alterar dados produtos <?php echo $dados["id"]; ?>

    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"crossorigin="anonymous"></script>

</head>
<body>
    <form action="produtos_editar_salvar.php" method="post">
        <div>
        <span> ID :</span>
        <input type="text" name="id" readonly
        value="<?php echo $dados["id"]; ?>" 
        />
        </div>


        <div> <!--div é como se fosse um coringa é invisivel ao olho nu, mas conseguimos dar formato a ela.-->
        <span> Nome do aluno :</span>
        <input type="text" name="nome"
        value="<?php echo $dados["nome"]; ?>"
        />
        
        </div>

        <div>
        <span> Preco :</span>
        <input type="text" name="preco"        
        value="<?php echo $dados["preco"]; ?>"
        />

        <div>
        <span> ID Categoria :</span>
        <input type="text" name="categoria_id"        
        value="<?php echo $dados["categoria_id"]; ?>"
        />

        </div>
        
        <div>
            
        <input type="submit" value="Salvar"
            class="btn btn-primary"/>

        <a href="/admin/produtos/index.php"
            class="btn btn-secondary" >
            Voltar </a>
        </div>
    </form>
</body>
</html>