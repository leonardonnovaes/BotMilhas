<?php
// Inicia a sessão para manter o login ativo
session_start();

// Importa a conexão com o banco de dados
require_once('conn.php');

// Esconde mensagens de erro no navegador (em produção é comum, mas em desenvolvimento é melhor exibir)
error_reporting(0);
ini_set("display_errors", 0 );

// Verifica se o usuário está logado (existe e-mail na sessão)
if($_SESSION['email'] == True){

  // Pega o e-mail salvo na sessão
  $email_cliente= $_SESSION['email'];

  // Busca os dados do usuário no banco
  $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn, $busca_email);

  // Conta quantos registros retornaram
  $total_clientes = mysqli_num_rows($resultado_busca);

  // Se encontrou registros, guarda os dados em variáveis
  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
    $email_cliente = $dados_usuario['email'];
    $senha_cliente= $dados_usuario['senha'];
    $nome_cliente= $dados_usuario['nome'];
    $tipo_cliente= $dados_usuario['tipo'];
  }

}else{
  // Caso não tenha sessão ativa, redireciona para login.php
  #echo "<meta http-equiv='refresh' content='0;url=login.php'>";   
?>
  <script type="text/javascript">
    window.location="login.php";
  </script>
<?php  
}
?>
<!DOCTYPE html>
<html lang="pt">
<title>NaneMilhas</title>
  <head>
    <meta charset="utf-8">
  
    <meta name="author" content="Adtile">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- CSS principal -->
    <link rel="stylesheet" href="css/index.css">

    <!-- Suporte a navegadores antigos (IE < 9) -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <link rel="stylesheet" href="css/ie.css">
    <![endif]-->

    <!-- Script para navegação responsiva -->
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>

<?php
// Descobre a página atual para marcar como "ativa" no menu
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>
     <header>
      <!-- Logo do sistema -->
      <a href="index.php" class="logo" data-scroll>
        <img src="./icons/nane-index-bg.png"  height="60" width="70">
      </a>

      <!-- Menu principal -->
      <nav class="nav-collapse">
        <ul>
          <li class="menu-item <?= ($paginaAtual == 'index.php') ? 'active' : '' ?>">
            <a href="index.php" data-scroll>PENDENTES</a>
          </li>
          <li class="menu-item <?= ($paginaAtual == 'aceitas.php') ? 'active' : '' ?>">
            <a href="aceitas.php" data-scroll>ACEITAS</a>
          </li>
          <li class="menu-item <?= ($paginaAtual == 'recusadas.php') ? 'active' : '' ?>">
            <a href="recusadas.php" data-scroll>RECUSADAS</a>
          </li>
          <li class="menu-item <?= ($paginaAtual == 'config.php') ? 'active' : '' ?>">
            <a href="config.php" data-scroll>CONFIGURAÇÕES</a>
          </li>
          <li class="menu-item <?= ($paginaAtual == 'sair.php') ? 'active' : '' ?>">
            <a href="sair.php" data-scroll>SAIR</a>
          </li>
        </ul>
      </nav>
    </header>

    <!-- Conteúdo principal -->
    <section id="home">
    <style>
      /* Espaço para CSS inline se precisar */
    </style>
</head>
<body>
  <div class="atualizasenha">
  <?php
  // Captura o parâmetro "senha" via GET
  $ok=$_GET['senha'];

  // Caso seja verdadeiro, exibe mensagem de confirmação
  if($ok == True){
    echo "<h1>Senha atualizada com sucesso</h1>";
  }
  ?>
  </div>

  <!-- Formulário para alterar senha -->
  <form method="post" action="senha_up.php" onsubmit="return verificaSenhas()">
    <h1>Adicionar nova senha</h1>

    <label for="senha">Nova senha:</label>
    <input type="password" id="senha" name="senha" required>

    <label for="confirmar_senha">Confirmar senha:</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha" required>

    <input type="submit" value="Adicionar senha">
  </form>
  <br>
  
  </body>
</html>
<script>
  // Verifica se os dois campos de senha são iguais antes de enviar
  function verificaSenhas() {
    var senha = document.getElementById("senha").value;
    var confirmar_senha = document.getElementById("confirmar_senha").value;

    if (senha != confirmar_senha) {
      alert("As senhas não são iguais!");
      return false; // Bloqueia envio
    }

    return true; // Permite envio
  }
</script>

<!-- Scripts adicionais -->
<script src="js/fastclick.js"></script>
<script src="js/scroll.js"></script>
<script src="js/fixed-responsive-nav.js"></script>
</body>
</html>
