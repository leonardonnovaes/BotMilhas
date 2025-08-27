<?php
session_start();
require_once('conn.php');
error_reporting(0);
ini_set("display_errors",0);
date_default_timezone_set('America/Sao_Paulo');
$now = time();
$data_hora = date('Y-m-d H:i:s', $now);



if($_SESSION['email']==True){


  $email_cliente=$_SESSION['email'];
  $busca_email = " SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn,$busca_email);
  $total_clientes = mysqli_num_rows($resultado_busca);

  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
    $email_cliente=$dados_usuario['email'];
    $senha_cliente=$dados_usuario['senha'];
    $nome_cliente=$dados_usuario['nome'];
    $tipo_cliente=$dados_usuario['tipo'];
  }




}else{
  echo "<meta http-equiv='refresh' content='0;url=login.php'> ";
?>

<script type="text/javascript">
  window.location="login.php"

<?php

}
$busca_pedidos = "SELECT * FROM cliente WHERE situacao = 'analise' AND email_painel = '$email_cliente'";
$resultado_pedidos = mysqli_query($conn, $busca_pedidos);
$total_pedidos = mysqli_num_rows($resultado_pedidos);

while($dados_pedidos = mysqli_fetch_array($resultado_pedidos)){
$id_cliente = $dados_pedidos['id'];
$nome_pedidos = $dados_pedidos['nome'];
$telefone_pedidos = $dados_pedidos['telefone'];
$destino = $dados_pedidos['destino_viagem'];
$ida = $dados_pedidos['data_ida'];
$volta = $dados_pedidos['data_volta'];
$qntd_pessoas = $dados_pedidos['quantidade_pessoas'];
$bagagem_despacho = $dados_pedidos['bagagem_despacho'];
}
?>

<?php
$id_cliente = $_POST['id_cliente'];


$sql = "INSERT IGNORE INTO cotacoes_2025 (telefone, nome, destino_viagem, ida, volta, quantidade_pessoas, bagagem_despacho, status, data_hora)
VALUES ('$telefone_pedidos', '$nome_pedidos', '$destino', '$ida', '$volta', '$qntd_pessoas', '$bagagem_despacho', 'recusado','$data_hora');
";
$query = mysqli_query($conn, $sql);



$sql = "DELETE FROM cliente WHERE id='$id_cliente'";
$query = mysqli_query($conn, $sql);
if(!$query){

    echo "NÃO FOI POSSIVEL ATUALIZAR";
}else{

    echo "<meta http-equiv='refresh' content='0;url=index.php'>";   

}

?>





?>

?>