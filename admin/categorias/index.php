<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:/Area_Publica/index.php');
    exit;
}

include("../banco.php");

if (isset($_GET['descricaoproduto'])) {
    $_SESSION['filtro_categoria'] = trim($_GET['descricaoproduto']);
} elseif (!isset($_SESSION['filtro_categoria'])) {
    $_SESSION['filtro_categoria'] = '';
}

$filtro = $_SESSION['filtro_categoria'];

$sql = "SELECT * FROM categorias";
if ($filtro !== '') {
    $filtro_escapado = $con->real_escape_string($filtro);
    $sql .= " WHERE nome LIKE '%$filtro_escapado%'";
}

$sql .= " ORDER BY id";
$retorno = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Categorias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="/images/title.png" />

    <style>
        body {
            background-color: #f8f9fa;
            padding: 40px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mb-3 d-flex justify-content-between">
            <a href="criar_categoria.php" class="btn btn-success">Cadastrar</a>
            <a href="/admin/dashboard.php" class="btn btn-secondary">Dashboard</a>
        </div>

        <h2>Pesquisar por nome da categoria</h2>
        <form action="index.php" method="get" class="form-inline mb-4">
            <input type="text" name="descricaoproduto" class="form-control mr-2" value="<?= htmlspecialchars($filtro) ?>">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
            <a href="index.php?descricaoproduto=" class="btn btn-outline-secondary ml-2">Limpar</a> 
        </form>

        <table class='table table-hover table-bordered'>
            <thead class="thead-light">
                <tr>
                    <th>ID Categoria</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($retorno && $retorno->num_rows > 0) {
                    foreach ($retorno as $linha):
                        ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>
                            <td><?= htmlspecialchars($linha['nome']) ?></td>
                            <td>
                                <form action="categorias_editar.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">✏️</button>
                                </form>
                                <form action="categorias_deletar.php" method="post" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                    <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                } else {
                    echo '<tr><td colspan="3" class="text-center">Nenhuma categoria encontrada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
