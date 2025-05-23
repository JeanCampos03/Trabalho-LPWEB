<title>Fut Camisas</title>
<link rel="icon" type="image/png" href="/images/title.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
crossorigin="anonymous"></script>


<?php
session_start();

include('../banco.php');

$sql_vendas = "SELECT v.id id_venda, v.data_venda data_venda, p.id id_produto, vi.quantidade qtd, p.nome, p.preco, c.nome categoria 
               FROM vendasitens vi
               JOIN vendas v ON v.id = vi.venda_id
               JOIN produtos p ON p.id = vi.produto_id
               JOIN categorias c ON c.id = p.categoria_id;";

$result = $con->query($sql_vendas);

?>
<style>
table, th, td {
  border: 2px solid black;
}
</style>

<a href="/admin/dashboard.php"> Voltar</a>

<table style="width:100%">
        <thead>
            <tr style='text-align:center'>
            <th>NÚMERO PEDIDO</th>
            <th>DATA</th>
            <th>ID PRODUTO</th>
            <th>NOME PRODUTO</th>
            <th>QUANTIDADE</th>
            <th>PREÇO</th> 
            <th>CATEGORIA</th>
            </tr>
        </thead>


<?php

    foreach($result as $vendas) {
        echo " 
               <tr style='text-align:center'>
               <td> " . "#" . $vendas['id_venda'] . "  </td> 
               <td> " . $vendas['data_venda'] . "  </td>
               <td> " . $vendas['id_produto'] . "  </td> 
               <td> " . $vendas['nome'] . "  </td> 
               <td> " . $vendas['qtd'] . "  </td>
               <td> " . $vendas['preco'] . "  </td>
               <td > " . $vendas['categoria'] . "  </td>
               </tr>
             ";
}
        
?>