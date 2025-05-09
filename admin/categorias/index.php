
<?php 
session_start();

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['senha']) == true))
{
  header('location:index.php');
  }

$logado = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Produtos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

</head>

<body>
    <a href="criar_categoria.php" class="btn btn-success ">
        CADASTRAR
    </a>

    <a href="/admin/dashboard.php" class="btn btn-secondary ">
        DASHBOARD
    </a>

    <body>
        <h2>Pesquise pela descrição</h2>
        <form action="index.php" method="get">
            <label for="aluno">Descrição do item</label>
            <input type="text" name="descricaoproduto">

            <input type="submit" value="Enviar">
        </form>

        <table class = 'table table-hower '>
             <thead>
                    <td>ID PRODUTO</td> 
                    <td>DESCRIÇÃO CATEGORIA</td>
                    <td>OPÇÕES</td>
             </thead>
    </body>

    <body>

        <tbody>

            <?php 
            include ("../banco.php");

            $descricao_item = "";

            if (isset($_GET['descricaoproduto'])) // isset() - essa função significa "existe?"
            {
                $descricao_item = ($_GET['descricaoproduto']);
            }

            $sql = "SELECT *
                    FROM categorias;";

            $retorno = $con->query($sql);

            if ($retorno) {
            } foreach ($retorno as $linha)
                echo "
                    <tr>
                    <td>" . $linha['id'] . "</td> 
                    <td>" . $linha['nome'] . "</td>

                            <td> 
                            <a href='/admin/categorias/categorias_deletar.php?id=" . $linha['id'] . " '
                            class='btn btn-danger' >🗑️                                
                            </a>

                            <a href='/admin/categorias/categorias_editar.php?id=" . $linha['id'] . " '
                            class='btn btn-primary' >✏️
                            </a>

                            </td>
                    </tr>
                    ";

            
            ?>
        </tbody>
    </body>

</html>