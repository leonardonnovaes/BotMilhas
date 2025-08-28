<?php
// Inclui o arquivo de conexão com o banco de dados
require_once('../conn.php');

// Pega o parâmetro "usuario" enviado via URL (GET)
$usuario_get = $_GET['usuario'];

// Desabilita exibição de erros (para não mostrar mensagens no navegador)
error_reporting(0);
ini_set("display_errors", 0);

// Busca na tabela 'envios' todas as mensagens pendentes (status = 1) 
// do usuário informado, em ordem decrescente de ID
$busca_cliente = "SELECT * FROM envios WHERE usuario = '$usuario_get' AND status = '1' ORDER BY id DESC";
$cliente = mysqli_query($conn, $busca_cliente);

// Percorre os resultados encontrados
while($dados_cliente = mysqli_fetch_array($cliente)){
    $id = $dados_cliente['id'];           // ID do envio
    $telefone = $dados_cliente['telefone']; // Telefone do cliente
    $msg = $dados_cliente['msg'];          // Mensagem a ser enviada
}

// Variável apenas para formatar a saída (separador ".n.")
$n = ".n.";

// Se existe algum telefone encontrado no SELECT acima
if(  $telefone == True){
    // Exibe a string "enviando" com as informações separadas por ".n."
    // Isso provavelmente será lido por outro sistema que consome este script
    echo "enviando{$n}$id{$n}$telefone{$n}$msg";
}

?>


<?php
// Define o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Captura o timestamp atual
$now = time();

// Converte para o formato de data e hora
$data_hora = date('Y-m-d H:i:s', $now);

// Define um limite de tempo (1 minuto atrás da hora atual)
$data_hora_limite = date('Y-m-d H:i:s',strtotime('-1 minutes', $now));

// Busca registros da tabela 'cliente' onde a última interação é menor que o limite
// e a situação não está em "analise" (ou seja, já está em atendimento, mas inativo)
$busca_pedidos = "SELECT * FROM cliente WHERE data_hora < '$data_hora_limite' AND situacao != 'analise'";
$resultado_pedido = mysqli_query($conn, $busca_pedidos);

// Percorre os registros encontrados
while($dados_pedidos = mysqli_fetch_array($resultado_pedido)){
    $id_cliente = $dados_pedidos['id'];           // ID do cliente
    $nome_pedidos = $dados_pedidos['nome'];       // Nome do cliente
    $telefone_pedidos = $dados_pedidos['telefone']; // Telefone do cliente
}

// Se foi encontrado algum cliente com inatividade
if($id_cliente == TRUE){
    // Define a mensagem automática de encerramento
    $msg = "Por falta de interação seu atendimento foi encerrado!";

    // Insere essa mensagem na tabela 'envios' para ser enviada
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$telefone_pedidos','$msg', '1','$usuario_get')";
    $query = mysqli_query($conn, $sql);

    // Se a mensagem foi inserida com sucesso
    if($query){
        // Remove o cliente da tabela 'cliente' (atendimento encerrado)
        $sql = "DELETE FROM cliente WHERE id='$id_cliente'";
        $query = mysqli_query($conn, $sql);
    }
}
?>
