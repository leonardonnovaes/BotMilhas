<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once('conn.php');

// Desativa exibição de erros (melhor apenas em produção)
error_reporting(0);
ini_set("display_errors", 0 );

// Verifica se a sessão do usuário (email) está ativa
if($_SESSION['email'] == True){

  // Pega o email salvo na sessão
  $email_cliente= $_SESSION['email'];

  // Consulta o usuário no banco
  $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn, $busca_email);
  $total_clientes = mysqli_num_rows($resultado_busca);

  // Percorre os dados do usuário logado
  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
    $email_cliente = $dados_usuario['email'];
    $senha_cliente= $dados_usuario['senha'];
    $nome_cliente= $dados_usuario['nome'];
    $tipo_cliente= $dados_usuario['tipo'];
  }

}else{
  // Caso não esteja logado, redireciona para login.php
  // echo "<meta http-equiv='refresh' content='0;url=login.php'>";   
?>
<script type="text/javascript">
	window.location="login.php";
</script>
<?php  
}
?>

<?php
// Define variável para controle de administrador (ainda não utilizada)
$adm = 0;
?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta name="author" content="Adtile">
    <title>NaneMilhas</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="./css/index.css">
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>
  <?php
  // Captura o nome do arquivo da página atual para destacar no menu
  $paginaAtual = basename($_SERVER['PHP_SELF']);
  ?>
    <header>
      <!-- Logo da página -->
      <a href="index.php" class="logo" data-scroll>
        <img src="./icons/nane-index-bg.png" height="60" width="70">
      </a>

      <!-- Menu de navegação -->
      <nav class="nav-collapse">
        <ul>
          <!-- Item "Pendentes" -->
          <li class="menu-item <?= ($paginaAtual == 'index.php') ? 'active' : '' ?>">
            <a href="index.php" data-scroll>PENDENTES</a>
          </li>
          <!-- Item "Aceitas" -->
          <li class="menu-item <?= ($paginaAtual == 'aceitas.php') ? 'active' : '' ?>">
            <a href="aceitas.php" data-scroll>ACEITAS</a>
          </li>
          <!-- Item "Recusadas" -->
          <li class="menu-item <?= ($paginaAtual == 'recusadas.php') ? 'active' : '' ?>">
            <a href="recusadas.php" data-scroll>RECUSADAS</a>
          </li>
          <!-- Item "Configurações" -->
          <li class="menu-item <?= ($paginaAtual == 'config.php') ? 'active' : '' ?>">
            <a href="config.php" data-scroll>CONFIGURAÇÕES</a>
          </li>
          <!-- Item "Sair" -->
          <li class="menu-item <?= ($paginaAtual == 'sair.php') ? 'active' : '' ?>">
            <a href="sair.php" data-scroll>SAIR</a>
          </li>
        </ul>
      </nav>
    </header>

    <section id="home">

  </head>
  <body>

<?php
  // Busca todas as cotações recusadas no banco
  $busca_pedidos = "SELECT * FROM cotacoes_2025 WHERE status = 'recusado'";
  $resultado_pedidos = mysqli_query($conn, $busca_pedidos);
  $total_pedidos = mysqli_num_rows($resultado_pedidos);

  // Percorre cada cotação recusada encontrada
  while($dados_pedidos = mysqli_fetch_array($resultado_pedidos)){
    $id_cliente = $dados_pedidos['id'];
    $nome_pedidos = $dados_pedidos['nome'];
    $telefone_pedidos = $dados_pedidos['telefone'];
    $situacao = $dados_pedidos['status'];
    $destino = $dados_pedidos['destino_viagem'];
    $ida = $dados_pedidos['ida'];
    $volta = $dados_pedidos['volta'];
    $qntd_pessoas = $dados_pedidos['quantidade_pessoas'];
    $bagagem_despacho = $dados_pedidos['bagagem_despacho'];
    $data_hora = $dados_pedidos['data_hora'];
?>

    <!-- Exibe detalhes da cotação recusada -->
    <form method="post">
      <h1>Detalhes da Cotação</h1>
      <table>
        <tr>
          <td>Cliente.</td>
          <td><?php echo "$nome_pedidos";?></td>
        </tr>
        <tr>
          <td>Telefone</td>
          <td><?php echo "$telefone_pedidos";?></td>
        </tr>
        <tr>
          <td>Destino</td>
          <td><?php echo "$destino";?></td>
        </tr>
        <tr>
          <td>Data ida</td>
          <td><?php echo "$ida";?></td>
        </tr>
        <tr>
          <td>Data volta</td>
          <td><?php echo "$volta";?></td>
        </tr>
        <tr>
          <td>Quantidade de pessoas</td>
          <td><?php echo "$qntd_pessoas";?> </td>
        </tr>
        <tr>
          <td>Bagagem para despacho</td>
          <td><?php echo "$bagagem_despacho";?> </td>
        </tr>
        <tr>
          <td>situação</td>
          <td><?php echo "$situacao";?> </td>
        </tr>
        <tr>
          <td>Finalizado em</td>
          <td><?php echo "$data_hora";?> </td>
        </tr>
      </table>
    </form>
    <br><br>

<?php
  } // fim do while das cotações
?>
  </body>
</html>
    </section>

    <!-- Scripts do site -->
    <script src="js/fastclick.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/fixed-responsive-nav.js"></script>
  </body>
</html>
