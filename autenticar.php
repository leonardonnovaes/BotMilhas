<?php
// Inicia a sessão para poder salvar variáveis de login
session_start();

// Inclui o arquivo de conexão com o banco
require_once('conn.php');

// Pega os dados enviados pelo formulário de login
$email_cliente = $_POST['email'];
$senha_cliente = $_POST['senha'];

// Consulta no banco se existe um usuário com esse e-mail e senha
$busca_email = "SELECT * FROM login WHERE email = '$email_cliente' AND senha = '$senha_cliente'";
$resultado_busca = mysqli_query($conn, $busca_email);

// Conta quantos registros foram encontrados
$total_clientes = mysqli_num_rows($resultado_busca);

// Se achou exatamente 1 usuário, login válido
if($total_clientes == 1){
    // Salva dados na sessão
    $_SESSION['email'] = $email_cliente;
    $_SESSION['senha'] = $senha_cliente;

    // Redireciona para o painel principal
    echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
}else{
    // Caso não encontre, redireciona para tela de erro de login
    echo "<meta http-equiv='refresh' content='0;url=login_falhou.php'> ";
}

?>
