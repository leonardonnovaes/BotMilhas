<?php
session_start();
require_once('conn.php');
error_reporting(0);
ini_set("display_errors", 0 );

if($_SESSION['email'] == True){

  $email_cliente= $_SESSION['email'];
  $busca_email = "SELECT * FROM login WHERE email = '$email_cliente'";
  $resultado_busca = mysqli_query($conn, $busca_email);
  $total_clientes = mysqli_num_rows($resultado_busca);

  while($dados_usuario = mysqli_fetch_array($resultado_busca)){
$email_cliente = $dados_usuario['email'];
$senha_cliente= $dados_usuario['senha'];
$nome_cliente= $dados_usuario['nome'];
$tipo_cliente= $dados_usuario['tipo'];
  }




}else{
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
    <link rel="stylesheet" href="css/index.css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <link rel="stylesheet" href="css/ie.css">
    <![endif]-->
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>
<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>
     <header>
      <a href="index.php" class="logo" data-scroll><img src="./icons/nane-index-bg.png"  height="60" width="70"></a>
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

    <section id="home">
    <style>
    
    
  </style>
</head>
<body>
  <div class="atualizasenha">
  <?php
$ok=$_GET['senha'];

if($ok ==True){
  echo "<h1>Senha atualizada com sucesso</h1>";
}

  ?></div>
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
  function verificaSenhas() {
    var senha = document.getElementById("senha").value;
    var confirmar_senha = document.getElementById("confirmar_senha").value;

    if (senha != confirmar_senha) {
      alert("As senhas não são iguais!");
      return false;
    }

    return true;
  }
</script>

  

    <script src="js/fastclick.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/fixed-responsive-nav.js"></script>
  </body>
</html>
