<?php

include("../banco.php");

$id_categorias = @$_GET['id'];

$sql_delete= "DELETE FROM categorias 
WHERE id = '$id_categorias' ";
        
$con->query($sql_delete);

header('location:/admin/categorias/index.php');

?>