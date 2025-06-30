<?php
require_once('../conn.php');
$usuario_get = $_GET['usuario'];

$busca_cliente = "SELECT * FROM envios WHERE usuario = '$usuario_get' AND status = '1' ORDER BY id DESC";
$cliente = mysqli_query($conn, $busca_cliente);

while($dados_cliente = mysqli_fetch_array($cliente)){
    $id = $dados_cliente['id'];
    $telefone = $dados_cliente['telefone'];
    $msg = $dados_cliente['msg'];
}




$n = ".n.";
if(  $telefone == True){

    echo "enviando{$n}$id{$n}$telefone{$n}$msg";

}

?>