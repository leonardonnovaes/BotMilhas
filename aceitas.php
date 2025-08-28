<?php
// Inicia a sessão
session_start();

// Conexão com o banco de dados
require_once('conn.php');

// Desabilita exibição de erros na tela
error_reporting(0);
ini_set("display_errors", 0 );

// ========================
// VERIFICA LOGIN
// ========================
if ($_SESSION['email'] == true) {
    // Captura o email armazenado na sessão
    $email_cliente = $_SESSION['email'];

    // Busca os dados do usuário logado
    $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
    $resultado_busca = mysqli_query($conn, $busca_email);
    $total_clientes = mysqli_num_rows($resultado_busca);

    // Se encontrou o usuário, pega seus dados
    while ($dados_usuario = mysqli_fetch_array($resultado_busca)) {
        $email_cliente = $dados_usuario['email'];
        $senha_cliente = $dados_usuario['senha'];
        $nome_cliente  = $dados_usuario['nome'];
        $tipo_cliente  = $dados_usuario['tipo'];
    }
} else {
    // Se não tiver sessão, redireciona para o login
    ?>
    <script type="text/javascript">
        window.location = "login.php";
    </script>
    <?php  
}
?>

<?php
// Variável que poderia ser usada para verificar permissões de administrador
$adm = 0;
?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta name="author" content="Adtile">
    <title>NaneMilhas</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Importa CSS do projeto -->
    <link rel="stylesheet" href="./css/index.css">
    <!-- Script de navegação responsiva -->
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>

  <?php
  // Captura o nome do arquivo da página atual
  $paginaAtual = basename($_SERVER['PHP_SELF']);
  ?>

  <!-- ========================= -->
  <!-- CABEÇALHO / MENU SUPERIOR -->
  <!-- ========================= -->
  <header>
    <a href="index.php" class="logo" data-scroll>
      <img src="./icons/nane-index-bg.png" height="60" width="70">
    </a>
    <nav class="nav-collapse">
      <ul>
        <!-- Cada item de menu fica "ativo" conforme a página atual -->
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

  <section id="home">

    <?php
    // =========================
    // LISTAGEM DE COTAÇÕES
    // =========================

    // Busca todas as cotações com status "sucesso"
    $busca_pedidos = "SELECT * FROM cotacoes_2025 WHERE status = 'sucesso'";
    $resultado_pedidos = mysqli_query($conn, $busca_pedidos);
    $total_pedidos = mysqli_num_rows($resultado_pedidos);

    // Exibe cada resultado em uma tabela
    while ($dados_pedidos = mysqli_fetch_array($resultado_pedidos)) {
        $id_cliente       = $dados_pedidos['id'];
        $nome_pedidos     = $dados_pedidos['nome'];
        $telefone_pedidos = $dados_pedidos['telefone'];
        $situacao         = $dados_pedidos['status'];
        $destino          = $dados_pedidos['destino_viagem'];
        $ida              = $dados_pedidos['ida'];
        $volta            = $dados_pedidos['volta'];
        $qntd_pessoas     = $dados_pedidos['quantidade_pessoas'];
        $bagagem_despacho = $dados_pedidos['bagagem_despacho'];
        $data_hora        = $dados_pedidos['data_hora'];
    ?>

    <!-- Formulário apenas para exibir informações (sem enviar nada) -->
    <form method="post">
      <h1>Detalhes da Cotação</h1>
      <table>
        <tr>
          <td>Cliente</td>
          <td><?php echo $nome_pedidos; ?></td>
        </tr>
        <tr>
          <td>Telefone</td>
          <td><?php echo $telefone_pedidos; ?></td>
        </tr>
        <tr>
          <td>Destino</td>
          <td><?php echo $destino; ?></td>
        </tr>
        <tr>
          <td>Data ida</td>
          <td><?php echo $ida; ?></td>
        </tr>
        <tr>
          <td>Data volta</td>
          <td><?php echo $volta; ?></td>
        </tr>
        <tr>
          <td>Quantidade de pessoas</td>
          <td><?php echo $qntd_pessoas; ?></td>
        </tr>
        <tr>
          <td>Bagagem para despacho</td>
          <td><?php echo $bagagem_despacho; ?></td>
        </tr>
        <tr>
          <td>Situação</td>
          <td><?php echo $situacao; ?></td>
        </tr>
        <tr>
          <td>Finalizado em</td>
          <td><?php echo $data_hora; ?></td>
        </tr>
      </table>
    </form>

    <br><br>

    <?php
    } // fim do while
    ?>
  </section>

  <!-- Scripts adicionais -->
  <script src="js/fastclick.js"></script>
  <script src="js/scroll.js"></script>
  <script src="js/fixed-responsive-nav.js"></script>
  </body>
</html>
