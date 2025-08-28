<?php
// Inicia a sessão
session_start();

// Inclui arquivo de conexão com o banco de dados
require_once('conn.php');

// Desativa exibição de erros (recomendado apenas em produção)
error_reporting(0);
ini_set("display_errors",0);

// Define fuso horário padrão
date_default_timezone_set('America/Sao_Paulo');

// Pega o timestamp atual e formata para padrão MySQL
$now = time();
$data_hora = date('Y-m-d H:i:s', $now);

// Verifica se a sessão do usuário está ativa
if($_SESSION['email']==True){

  // Pega o email da sessão
  $email_cliente=$_SESSION['email'];

  // Busca os dados do usuário logado
  $busca_email = " SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn,$busca_email);
  $total_clientes = mysqli_num_rows($resultado_busca);

  // Salva os dados do usuário
  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
    $email_cliente=$dados_usuario['email'];
    $senha_cliente=$dados_usuario['senha'];
    $nome_cliente=$dados_usuario['nome'];
    $tipo_cliente=$dados_usuario['tipo'];
  }

}else{
  // Caso não tenha sessão, redireciona para login.php
  echo "<meta http-equiv='refresh' content='0;url=login.php'> ";
?>
<script type="text/javascript">
  window.location="login.php"
</script>
<?php
}

// Busca pedidos na tabela cliente com situação "analise" vinculados ao email do painel
$busca_pedidos = "SELECT * FROM cliente WHERE situacao = 'analise' AND email_painel = '$email_cliente'";
$resultado_pedidos = mysqli_query($conn, $busca_pedidos);
$total_pedidos = mysqli_num_rows($resultado_pedidos);

// Percorre cada pedido retornado
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
// Pega o ID do cliente enviado pelo formulário
$id_cliente = $_POST['id_cliente'];

// Insere os dados da cotação na tabela cotacoes_2025 com status "recusado"
$sql = "INSERT IGNORE INTO cotacoes_2025 (telefone, nome, destino_viagem, ida, volta, quantidade_pessoas, bagagem_despacho, status, data_hora)
VALUES ('$telefone_pedidos', '$nome_pedidos', '$destino', '$ida', '$volta', '$qntd_pessoas', '$bagagem_despacho', 'recusado','$data_hora');
";
$query = mysqli_query($conn, $sql);

// Exclui o registro original da tabela cliente (já que foi movido para cotacoes_2025)
$sql = "DELETE FROM cliente WHERE id='$id_cliente'";
$query = mysqli_query($conn, $sql);

// Verifica se a exclusão foi bem-sucedida
if(!$query){
    echo "NÃO FOI POSSIVEL ATUALIZAR";
}else{
    // Redireciona para index.php após concluir
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";   
}

?>
