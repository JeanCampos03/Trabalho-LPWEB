<?php
session_start();

$id = (int)$_GET['id'];
if (isset($_SESSION['carrinho'][$id])) {
    unset($_SESSION['carrinho'][$id]);
}

header("Location: carrinhu.php");
exit();
