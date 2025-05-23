<?php
session_start();
include('../banco.php');

$filtro = '';
if (isset($_GET['busca']) && is_numeric($_GET['busca'])) {
    $id_filtro = intval($_GET['busca']);
    $filtro = "WHERE v.id = $id_filtro";
}

$sql_vendas = "SELECT v.id AS id_venda, v.data_venda, p.id AS id_produto, vi.quantidade, p.nome, p.preco, c.nome AS categoria
               FROM vendasitens vi
               JOIN vendas v ON v.id = vi.venda_id
               JOIN produtos p ON p.id = vi.produto_id
               JOIN categorias c ON c.id = p.categoria_id
               $filtro
               ORDER BY v.id, p.nome";

$result = $con->query($sql_vendas);

$vendas_agrupadas = [];
foreach ($result as $linha) {
    $id = $linha['id_venda'];
    $vendas_agrupadas[$id]['data'] = $linha['data_venda'];
    $vendas_agrupadas[$id]['produtos'][] = $linha;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Fut Camisas - Vendas</title>
    <link rel="icon" href="/images/title.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        table, th, td {
            border: 1px solid #000;
        }
        h5 {
            margin-top: 30px;
        }
    </style>
</head>
<body class="container py-4">
    <a href="/admin/dashboard.php" class="btn btn-secondary mb-3">← Voltar</a>

    <h2>Relatório de Vendas</h2>
    
    <form method="get" class="form-inline mb-4">
        <label for="busca" class="mr-2">Buscar por Nº da Venda:</label>
        <input type="number" name="busca" id="busca" class="form-control mr-2" value="<?= isset($_GET['busca']) ? $_GET['busca'] : '' ?>" placeholder="Digite o número da venda">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="index.php" class="btn btn-outline-secondary ml-2">Limpar</a>
    </form>

    <?php if (count($vendas_agrupadas) === 0): ?>
        <p>Nenhuma venda encontrada.</p>
    <?php else: ?>
        <?php foreach ($vendas_agrupadas as $id_venda => $dados): ?>
            <h5>Pedido #<?= $id_venda ?> - Data: <?= $dados['data'] ?></h5>
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Produto</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['produtos'] as $produto): ?>
                        <tr>
                            <td><?= $produto['id_produto'] ?></td>
                            <td><?= $produto['nome'] ?></td>
                            <td><?= $produto['quantidade'] ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= $produto['categoria'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
