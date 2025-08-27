<?php
require_once('../conn.php');
$usuario_get = $_GET['usuario'];

error_reporting(0);
ini_set("display_errors", 0);

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

<?php
date_default_timezone_set('America/Sao_Paulo');
$now = time();
$data_hora = date('Y-m-d H:i:s', $now);
$data_hora_limite = date('Y-m-d H:i:s',strtotime('-1 minutes', $now));

$busca_pedidos = "SELECT * FROM cliente WHERE data_hora < '$data_hora_limite' AND situacao != 'analise'";
$resultado_pedido = mysqli_query($conn, $busca_pedidos);
while($dados_pedidos = mysqli_fetch_array($resultado_pedido)){
$id_cliente = $dados_pedidos['id'];
$nome_pedidos = $dados_pedidos['nome'];
$telefone_pedidos = $dados_pedidos['telefone'];}
if($id_cliente == TRUE){
    $msg = "Por falta de interação seu atendimento foi encerrado!";
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$telefone_pedidos','$msg', '1','$usuario_get')";
    $query = mysqli_query($conn, $sql);
    if($query){
        $sql = "DELETE FROM cliente WHERE id='$id_cliente'";
        $query = mysqli_query($conn, $sql);
    }
}
?>