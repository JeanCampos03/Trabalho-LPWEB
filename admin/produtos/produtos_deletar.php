
<?php
include("../banco.php");

$id_produto = @$_GET['id'];

$sql_delete= "DELETE FROM produtos 
WHERE id = '$id_produto'";
        
$con->query($sql_delete);

header('location:/admin/produtos/index.php');


?>