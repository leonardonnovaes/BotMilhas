<?php
// Inicia a sessão para controlar login
session_start();

// Importa a conexão com o banco
require_once('conn.php');

// Desliga exibição de erros no navegador
error_reporting(0);
ini_set("display_errors", 0 );

// Verifica se existe sessão com e-mail do usuário
if($_SESSION['email'] == True){

  $email_cliente= $_SESSION['email'];

  // Busca dados do usuário logado
  $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn, $busca_email);
  $total_clientes = mysqli_num_rows($resultado_busca);

  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
    $email_cliente = $dados_usuario['email'];
    $senha_cliente= $dados_usuario['senha'];
    $nome_cliente= $dados_usuario['nome'];
    $tipo_cliente= $dados_usuario['tipo'];

    // Se for um usuário comum (tipo 1), redireciona para index.php
    if($tipo_cliente == '1'){
      echo "<meta http-equiv='refresh' content='0;url=index.php'>"; 
    }
  }

}else{
  // Caso não esteja logado, redireciona para login.php
  ?>
  <script type="text/javascript">
    window.location="login.php";
  </script>
  <?php  
}
?>
<?php
// Recebe os dados do formulário via POST
$id_usuario = $_POST['id_usuario']; // ID do usuário que será atualizado
$status = $_POST['status'];         // Novo status

// Cria a query de atualização
$sql = "UPDATE login SET status = '$status' WHERE id='$id_usuario'";
$query = mysqli_query($conn, $sql);

// Verifica se a atualização funcionou
if(!$query){
    echo "NÃO FOI POSSÍVEL ATUALIZAR";
}else{
    // Redireciona para admin.php informando sucesso (GET ?valor=ok)
    echo "<meta http-equiv='refresh' content='0;url=admin.php?valor=ok'>";   
}
?>
