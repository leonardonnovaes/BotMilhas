<?php
require_once('../conn.php'); // Conexão com o banco de dados

//######################################################################
//###################### VARIÁVEIS INICIAIS
$numero_get = $_GET['telefone']; // Número do cliente (WhatsApp/telefone)
$usuario_get = $_GET['usuario']; // Usuário que está atendendo (painel)
$msg_usuario = $_GET['msg'];     // Mensagem enviada pelo cliente

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');
$now = time();
$data_hora = date('Y-m-d H:i:s', $now); // Data/hora atual

//######################################################################
//###################### FUNÇÕES AUXILIARES
function primeiraLetraMaiuscula($texto) {
    // Transforma a primeira letra em maiúscula e o resto em minúsculo
    $primeiraLetra = mb_strtoupper(mb_substr($texto, 0, 1));
    $restante = mb_strtolower(mb_substr($texto, 1));
    return $primeiraLetra . $restante;
}

function ehDataValida($data) {
    // Verifica se a data enviada está no formato AAAA-MM-DD
    $d = DateTime::createFromFormat('Y-m-d', $data);
    return $d && $d->format('Y-m-d') === $data;
}

function ehNumero($texto){
    // Retorna true se for número
    return is_numeric($texto);
}

//######################################################################
//###################### CONSULTA CLIENTE
// Busca cliente existente pelo telefone e usuário
$busca_cliente = "SELECT * FROM cliente WHERE telefone = '$numero_get' AND email_painel = '$usuario_get'";
$cliente = mysqli_query($conn, $busca_cliente);
$total_cliente = mysqli_num_rows($cliente);

// Se já existe cliente, carrega os dados em variáveis
if ($total_cliente == 1) {
    $dados_cliente = mysqli_fetch_assoc($cliente);
    extract($dados_cliente); // Cria variáveis automáticas com nomes das colunas (ex: $nome, $destino_viagem, etc.)
}

// Caso o cliente já esteja com situação = analise, envia mensagem de "aguarde"
if ($situacao == 'analise') {
    $msg = 'Peço por gentileza que aguarde. Assim que finalizada um de nossos especialistas entrará em contato😊.';
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1' ,'$usuario_get')";
    mysqli_query($conn, $sql);
}

//######################################################################
//###################### CADASTRA NOVO CLIENTE
if($total_cliente == 0){
    // Se não existe cliente, cria um novo registro
    $sql = "INSERT INTO cliente (telefone, email_painel, data_hora)  
            VALUES ('$numero_get','$usuario_get','$data_hora')";
    $query = mysqli_query($conn, $sql);
  
    if($query){
        // Primeira mensagem automática após cadastro
        $msg = 'Ola, Para começar, me diga seu nome 😊';
        $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1' ,'$usuario_get')";
        mysqli_query($conn, $sql);
    }
    exit; // Interrompe execução após cadastrar
}

//######################################################################
//###################### COLETA DO NOME
if($nome == NULL){
    // Se ainda não coletou o nome do cliente
    $msg_usuario = primeiraLetraMaiuscula($msg_usuario);

    // Atualiza no banco o nome informado
    $sql = "UPDATE cliente SET nome = '$msg_usuario', data_hora = '$data_hora' WHERE telefone = '$numero_get'";
    mysqli_query($conn, $sql);

    // Envia próxima pergunta
    $msg = "Ok *$msg_usuario*, Seja bem-vindo! Me chamo Nane, e vamos continuar 😊. Para onde pretende viajar?";
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DESTINO DA VIAGEM
if($destino_viagem == NULL){
    // Salva destino informado
    $sql = "UPDATE cliente SET destino_viagem = '$msg_usuario', data_hora = '$data_hora' WHERE telefone = '$numero_get'";
    mysqli_query($conn, $sql);

    // Pergunta próxima informação
    $msg = "Ok $msg_usuario é um ótimo lugar para visitar, qual a data de ida? (Formato: AAAA-MM-DD)";
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DATA DE IDA
if($data_ida == NULL){
    if(ehDataValida($msg_usuario)){
        // Atualiza data de ida
        $sql = "UPDATE cliente SET data_ida = '$msg_usuario', data_hora = '$data_hora' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);

        $msg = "E qual a data de volta? (Formato: AAAA-MM-DD)";
    } else {
        // Se formato inválido, pede novamente
        $msg = "Data inválida. Por favor, envie no formato: AAAA-MM-DD.";
    }
    // Envia resposta ao cliente
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### DATA DE VOLTA
if($data_volta == NULL){
    if(ehDataValida($msg_usuario)){
        // Atualiza data de volta
        $sql = "UPDATE cliente SET data_volta = '$msg_usuario', data_hora = '$data_hora' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);

        $msg = "Quantas pessoas vão viajar?";
    } else {
        // Se formato inválido
        $msg = "Data inválida. Por favor, envie no formato: AAAA-MM-DD.";
    }
    // Envia resposta
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### QUANTIDADE DE PESSOAS
if($quantidade_pessoas == NULL){
    if(ehNumero($msg_usuario)){
        // Atualiza número de pessoas
        $sql = "UPDATE cliente SET quantidade_pessoas = '$msg_usuario', data_hora = '$data_hora' WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);

        $msg = "Há bagagem para despacho? (Responda com *Sim* ou *Não*)";
    } else {
        // Se não for número
        $msg = "Por favor, envie apenas o número de pessoas (ex: 3).";
    }
    // Envia resposta
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}

//######################################################################
//###################### BAGAGEM PARA DESPACHO
if($bagagem_despacho == NULL){
    // Normaliza resposta (sim/não)
    $resposta = strtolower(trim($msg_usuario));
    if($resposta === 'sim' || $resposta === 'não' || $resposta === 'nao'){
        $resposta_formatada = ($resposta === 'nao') ? 'Não' : ucfirst($resposta);

        // Atualiza no banco que já coletou todas as infos
        $sql = "UPDATE cliente 
                SET bagagem_despacho = '$resposta_formatada',
                    situacao = 'analise',
                    data_hora = '$data_hora'
                WHERE telefone = '$numero_get'";
        mysqli_query($conn, $sql);

        // Mensagem final
        $msg = "Obrigado! Todas as informações foram registradas com sucesso. Em breve entraremos em contato para continuar o atendimento. ✈️";
    } else {
        // Caso não responda sim/não corretamente
        $msg = "Por favor, responda com *Sim* ou *Não* sobre a bagagem para despacho.";
    }
    // Envia resposta
    $sql = "INSERT INTO envios (telefone, msg , status,usuario) VALUES ('$numero_get','$msg', '1','$usuario_get')";
    mysqli_query($conn, $sql);
    exit;
}
?>
