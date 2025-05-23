<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('Location: index.php');
    exit;
}

$logado = $_SESSION['usuario'];

include("../banco.php");

if (isset($_GET['descricaoproduto'])) {
    $_SESSION['filtro_descricao'] = trim($_GET['descricaoproduto']);
} elseif (!isset($_SESSION['filtro_descricao'])) {
    $_SESSION['filtro_descricao'] = '';
}

if (isset($_GET['categ'])) {
    $_SESSION['filtro_categ'] = trim($_GET['categ']);
} elseif (!isset($_SESSION['filtro_categ'])) {
    $_SESSION['filtro_categ'] = '';
}

$filtro = $_SESSION['filtro_descricao'];
$FiltroCateg = $_SESSION['filtro_categ'];

$sql = "SELECT p.*, c.nome AS nome_categoria 
        FROM produtos p
        INNER JOIN categorias c ON p.categoria_id = c.id ";

if ($filtro !== '' && $FiltroCateg == '') {
    $filtro_result = $con->real_escape_string($filtro);
    $sql .= "WHERE p.nome LIKE '%$filtro_result%' ";
}
elseif ($FiltroCateg !== '' && $filtro == ''){
    $filtro_result = $con->real_escape_string($FiltroCateg);
    $sql .= "WHERE c.nome LIKE '%$filtro_result%' ";       
}
elseif($FiltroCateg !== '' && $filtro !== ''){
    $filtro_result = $con->real_escape_string($filtro);
    $filtro_resultCateg = $con->real_escape_string($FiltroCateg);
    $sql .= "WHERE p.nome LIKE '%$filtro_result%' 
            and c.nome LIKE '%$filtro_resultCateg%'";       
}



$sql .= "ORDER BY p.id";

$retorno = $con->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Consulta de Produtos</title>
    <link rel="icon" type="image/png" href="/images/title.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
</head>

<body class="p-4">

    <div class="mb-3">
        <a href="produtos_cadastrar.php" class="btn btn-success mr-2">Cadastrar</a>
        <a href="/admin/dashboard.php" class="btn btn-secondary">Dashboard</a>
    </div>

    <h2>Filtro</h2>
    <form action="index.php" method="get" class="form-inline mb-4">
        <label for="descricaoproduto" class="mr-2">Descrição do item</label>
        <input type="text" name="descricaoproduto" id="descricaoproduto" class="form-control mr-2"
            value="<?= htmlspecialchars($filtro) ?>" />
        <label for="categ" class="mr-2">Nome da categoria</label>
        <input type="text" name="categ" id="categ" class="form-control mr-2"
            value="<?= htmlspecialchars($FiltroCateg) ?>" />    
        <button type="submit" class="btn btn-primary">Pesquisar</button>        
    </form>

    <table class="table table-hover table-bordered">
        <thead class="thead-light">
            <tr>
                <th>ID Produto</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($retorno && $retorno->num_rows > 0) {
                while ($linha = $retorno->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . (int)$linha['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                    echo "<td>R$ " . number_format($linha['preco'], 2, ',', '.') . "</td>";
                    echo "<td>" . htmlspecialchars($linha['nome_categoria']) . "</td>";
                    echo "<td>";
                    
                    echo "<form action='produtos_editar.php' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . (int)$linha['id'] . "'>
                            <button type='submit' class='btn btn-primary btn-sm' title='Editar'>✏️</button>
                          </form> ";

                    echo "<form action='produtos_deletar.php' method='post' style='display:inline;' 
                            onsubmit=\"return confirm('Tem certeza que deseja excluir este produto?');\">
                            <input type='hidden' name='id' value='" . (int)$linha['id'] . "'>
                            <button type='submit' class='btn btn-danger btn-sm' title='Deletar'>🗑️</button>
                          </form>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="5" class="text-center">Nenhum produto encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>

</body>

</html>
