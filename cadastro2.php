<?php
// Conexão com o banco de dados
require_once('conn.php');

// Exibe todos os dados recebidos via GET, POST ou COOKIE (usado para debug)
// Quando o cadastro for finalizado, você pode remover ou comentar essa linha
print_r($_REQUEST);
?>

<?php
    // Pega os dados enviados pelo formulário (cadastro.php)
    $nome_cliente  = $_POST['nome'];   // Nome digitado
    $senha_cliente = $_POST['senha'];  // Senha digitada
    $email_cliente = $_POST['email'];  // E-mail digitado

    // Busca no banco de dados se já existe alguém com o mesmo e-mail
    $busca_email = " SELECT * FROM login WHERE email = '$email_cliente' ";
    $resultado_busca = mysqli_query($conn, $busca_email);
    $total_clientes = mysqli_num_rows($resultado_busca); // Conta quantos registros encontrou

    // Apenas para debug: mostra se encontrou ou não usuários
    echo $total_clientes;

    // --- VERIFICAÇÃO ---
    // Se já existir alguém com esse e-mail, redireciona para página de erro
    if($total_clientes > 0){
        echo "<meta http-equiv='refresh' content='0;url=email_ja_cadastrado.php'> ";
    }else{
        // Se não existir, insere um novo cadastro no banco
        // Tipo = '1' (provavelmente cliente comum, depende da sua lógica)
        $sql = "INSERT INTO login (nome, senha, email, tipo) 
                VALUES ('$nome_cliente','$senha_cliente','$email_cliente','1')";
        $query = mysqli_query($conn, $sql);

        // Verifica se o insert deu erro
        if(!$query){
            // Caso erro → redireciona para erro_cadastro.php
            echo "<meta http-equiv='refresh' content='0;url=erro_cadastro.php'>";
        }else{
            // Caso sucesso → redireciona para sucesso.php
            echo "<meta http-equiv='refresh' content='0;url=sucesso.php'> ";
        }
    }
?>
