<?php
// Inicia a sessão
session_start();

// Importa a conexão com o banco de dados
require_once('conn.php');

// Desativa exibição de erros no navegador (mas não é boa prática em produção — melhor usar logs)
error_reporting(0);
ini_set("display_errors", 0);

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Captura o timestamp atual
$now = time();
$data_hora = date('Y-m-d H:i:s', $now);

// ========================================================
// VERIFICA SE O USUÁRIO ESTÁ LOGADO
// ========================================================
if($_SESSION['email'] == True){

    // Recupera o e-mail da sessão
    $email_cliente = $_SESSION['email'];

    // Busca os dados do usuário logado
    $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
    $resultado_busca = mysqli_query($conn, $busca_email);
    $total_clientes = mysqli_num_rows($resultado_busca);

    // Guarda as informações do usuário
    while($dados_usuario = mysqli_fetch_array($resultado_busca)){
        $email_cliente = $dados_usuario['email'];
        $senha_cliente = $dados_usuario['senha'];
        $nome_cliente  = $dados_usuario['nome'];
        $tipo_cliente  = $dados_usuario['tipo'];
    }

}else{
    // Caso não tenha sessão ativa, redireciona para login.php
    echo "<meta http-equiv='refresh' content='0;url=login.php'> ";
?>
    <script type="text/javascript">
        window.location = "login.php";
    </script>
<?php
}

// ========================================================
// BUSCA PEDIDOS EM ANÁLISE DO CLIENTE LOGADO
// ========================================================
$busca_pedidos = "SELECT * FROM cliente WHERE situacao = 'analise' AND email_painel = '$email_cliente'";
$resultado_pedidos = mysqli_query($conn, $busca_pedidos);
$total_pedidos = mysqli_num_rows($resultado_pedidos);

// Recupera os dados do pedido (se houver)
while($dados_pedidos = mysqli_fetch_array($resultado_pedidos)){
    $id_cliente       = $dados_pedidos['id'];
    $nome_pedidos     = $dados_pedidos['nome'];
    $telefone_pedidos = $dados_pedidos['telefone'];
    $destino          = $dados_pedidos['destino_viagem'];
    $ida              = $dados_pedidos['data_ida'];
    $volta            = $dados_pedidos['data_volta'];
    $qntd_pessoas     = $dados_pedidos['quantidade_pessoas'];
    $bagagem_despacho = $dados_pedidos['bagagem_despacho'];
}
?>

<?php
// ========================================================
// RECEBE O ID DO CLIENTE VIA POST
// ========================================================
$id_cliente = $_POST['id_cliente'];

// ========================================================
// INSERE OS DADOS NA TABELA DE COTAÇÕES (cotacoes_2025)
// ========================================================
// OBS: "INSERT IGNORE" não insere se já existir duplicado na chave única
$sql = "INSERT IGNORE INTO cotacoes_2025 (
            telefone, nome, destino_viagem, ida, volta, quantidade_pessoas, bagagem_despacho, status, data_hora
        )
        VALUES (
            '$telefone_pedidos', 
            '$nome_pedidos', 
            '$destino', 
            '$ida', 
            '$volta', 
            '$qntd_pessoas', 
            '$bagagem_despacho', 
            'sucesso',
            '$data_hora'
        )";

$query = mysqli_query($conn, $sql);

// ========================================================
// REMOVE O PEDIDO DA TABELA CLIENTE
// ========================================================
$sql = "DELETE FROM cliente WHERE id='$id_cliente'";
$query = mysqli_query($conn, $sql);

// Verifica se o DELETE foi bem-sucedido
if(!$query){
    echo "NÃO FOI POSSIVEL ATUALIZAR";
}else{
    // Se deu certo, redireciona para a página inicial
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}

?>
