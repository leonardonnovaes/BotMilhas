<?php
require_once('../conn.php');

//######################################################################
//###################### VARIÁVEIS INICIAIS
$numero_get = $_GET['telefone'];
$usuario_get = $_GET['usuario'];
$msg_usuario = $_GET['msg'];

date_default_timezone_set('America/Sao_Paulo');
$now = time();
$data_hora = date('Y-m-d H:i:s', $now);

//######################################################################
//###################### FUNÇÕES AUXILIARES

function primeiraLetraMaiuscula($texto) {
    $primeiraLetra = mb_strtoupper(mb_substr($texto, 0, 1));
    $restante = mb_strtolower(mb_substr($texto, 1));
    return $primeiraLetra . $restante;
}

function ehDataValida($data) {
    $d = DateTime::createFromFormat('Y-m-d', $data);
    return $d && $d->format('Y-m-d') === $data;
}

function ehNumero($texto){
    return is_numeric($texto);
}

//######################################################################
//###################### CONSULTA CLIENTE
$busca_cliente = "SELECT * FROM cliente WHERE telefone = '$numero_get' AND email_painel = '$usuario_get'";
$cliente = mysqli_query($conn, $busca_cliente);
$total_cliente = mysqli_num_rows($cliente);



// Inicializa variáveis com dados do cliente (se existir)
if ($total_cliente == 1) {
    $dados_cliente = mysqli_fetch_assoc($cliente);
    extract($dados_cliente); // Cria variáveis com base nos nomes das colunas
    
}
if ($situacao == 'analise') {
    $msg = 'Peço por gentileza que aguarde. Assim que finalizada um de nossos especialistas entrará em contato😊.';
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1' ,'$usuario_get')";
    mysqli_query($conn, $sql);
}

//######################################################################
//###################### CADASTRA NOVO CLIENTE
if($total_cliente == 0){
    $sql = "INSERT INTO cliente (telefone, email_painel )  VALUES ('$numero_get','$usuario_get')";
    $query = mysqli_query($conn, $sql);
  

    if($query){
        $msg = 'Para começar, me diga seu nome 😊';
        $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1' ,'$usuario_get')";
        mysqli_query($conn, $sql);
    }
    exit;
}

//######################################################################
//###################### COLETA DO NOME
if($nome == NULL){
    $msg_usuario = primeiraLetraMaiuscula($msg_usuario);
    $sql = "UPDATE cliente SET nome = '$msg_usuario' WHERE telefone = '$numero_get'";
    mysqli_query($conn, $sql);
   

    $msg = "Ok *$msg_usuario*, Seja bem-vindo! Me chamo Nane, e vamos continuar 😊. Para onde pretende viajar?";

    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DESTINO DA VIAGEM
if($destino_viagem == NULL){
    $sql = "UPDATE cliente SET destino_viagem = '$msg_usuario' WHERE telefone = '$numero_get'";
    mysqli_query($conn, $sql);
   

    $msg = "Qual a data de ida? (Formato: AAAA-MM-DD)";
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DATA DE IDA
if($data_ida == NULL){
    if(ehDataValida($msg_usuario)){
        $sql = "UPDATE cliente SET data_ida = '$msg_usuario' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);
       

        $msg = "E qual a data de volta? (Formato: AAAA-MM-DD)";
    } else {
        $msg = "Data inválida. Por favor, envie no formato: AAAA-MM-DD.";
    }
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DATA DE VOLTA
if($data_volta == NULL){
    if(ehDataValida($msg_usuario)){
        $sql = "UPDATE cliente SET data_volta = '$msg_usuario' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);
        

        $msg = "Quantas pessoas vão viajar?";
    } else {
        $msg = "Data inválida. Por favor, envie no formato: AAAA-MM-DD.";
    }
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### QUANTIDADE DE PESSOAS
if($quantidade_pessoas == NULL){
    if(ehNumero($msg_usuario)){
        $sql = "UPDATE cliente SET quantidade_pessoas = '$msg_usuario' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);
       

        $msg = "Há bagagem para despacho? (Responda com *Sim* ou *Não*)";
    } else {
        $msg = "Por favor, envie apenas o número de pessoas (ex: 3).";
    }
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### BAGAGEM PARA DESPACHO
if($bagagem_despacho == NULL){
    $resposta = strtolower(trim($msg_usuario));
    if($resposta === 'sim' || $resposta === 'não' || $resposta === 'nao'){
        $resposta_formatada = ($resposta === 'nao') ? 'Não' : ucfirst($resposta);
        $sql = "UPDATE cliente SET bagagem_despacho = '$resposta_formatada' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);
        
        $sql = "UPDATE cliente SET situacao = 'analise' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);

        $msg = "Obrigado! Todas as informações foram registradas com sucesso. Em breve entraremos em contato para continuar o atendimento. ✈️";
    } else {
        $msg = "Por favor, responda com *Sim* ou *Não* sobre a bagagem para despacho.";
    }
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}
?>
