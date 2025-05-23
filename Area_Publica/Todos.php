<?php
session_start();
unset($_SESSION['categoria_filtro']);
header('Location: filtro_todos.php');
exit;
?>