<?php
session_start();


include('../admin/banco.php'); 

//Pegar produtos
$sql = "SELECT * FROM produtos";
$resultado = $con->query($sql);


//Adicionar eles ao carrinho

if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    if (!isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] = 1;
    } else {
        $_SESSION['carrinho'][$id]++;
    }
    header("Location: carrinhu.php");
    exit();
}
?>

<h2>Produtos :</h2>
<ul>
<?php foreach ($resultado as $linha) { ?>

    <li>
        <?= $linha['nome'] ?> - R$ <?= number_format($linha['preco'], 2, ',', '.') ?>
        <a href="?add=<?= $linha['id'] ?>">Adicionar ao carrinho</a>
    </li>

<?php } ?>

</ul>

<p><a href="carrinhu.php">Ver carrinho</a></p>