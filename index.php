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

$prod_gas = $dados_usuario['prod_gas'];
$prod_agua= $dados_usuario['prod_agua'];


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


<?php
$adm = 0;

?>

<!DOCTYPE html>
<html lang="pt">
  <head>
  <meta name="author" content="Adtile">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <link rel="stylesheet" href="css/ie.css">
    <![endif]-->
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>

    <header>
      <a href="index.php" class="logo" data-scroll>DELIVERY</a>
      <nav class="nav-collapse">
        <ul>
          <li class="menu-item active"><a href="index.php" data-scroll>VENDAS</a></li>
          <li class="menu-item"><a href="produtos.php" data-scroll>PRODUTOS</a></li>
          <li class="menu-item"><a href="pedidos.php" data-scroll>PEDIDOS</a></li>
          <li class="menu-item"><a href="config.php" data-scroll>CONFIGURAÇÕES</a></li>
          <?php
          if($tipo_cliente == 2){
            ?>
             
          <li class="menu-item"><a href="admin.php" data-scroll>ADMIN</a></li>      
          <?php
          }
          ?>
          <li class="menu-item"><a href="sair.php" data-scroll>SAIR</a></li>
    
        </ul>
      </nav>
    </header>

    <section id="home">

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      
      body {
        font-family: Arial, sans-serif;
        background-color: #ddddddff;
      }
      
      form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        margin: 0 auto;
      }
      
      h1 {
        margin-bottom: 10px;
      }
      
      table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
      }
      
      th,
      td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      
      th {
        background-color: #eee;
      }
      
      td:first-child {
        font-weight: bold;
      }
      #button_aceitar{
        background-color: green;
        height: 40px;
        width: 80px;
        font-weight: bold;
        border-radius: 20px;
        margin: 50px;
        cursor: pointer;
        border: none;
      }
      #button_recusar{
        background-color: #ff2400;
        height: 40px;
        width: 80px;
        font-weight: bold;
        border-radius: 20px;
        margin: 50px;
        cursor: pointer;
        border: none;
      }
    </style>
  </head>
  <body>


<?php
  #$email_cliente= $_SESSION['email'];
  $busca_pedidos = "SELECT * FROM cliente WHERE situacao = 'analise' AND email_painel = '$email_cliente'";
  $resultado_pedidos = mysqli_query($conn, $busca_pedidos);
  $total_pedidos = mysqli_num_rows($resultado_pedidos);

  while($dados_pedidos = mysqli_fetch_array($resultado_pedidos)){
$id_cliente = $dados_pedidos['id'];
$nome_pedidos = $dados_pedidos['nome'];
$telefone_pedidos = $dados_pedidos['telefone'];
$situacao = $dados_pedidos['situacao'];
$email_painel = $dados_pedidos['email_painel'];
$destino = $dados_pedidos['destino_viagem'];
$ida = $dados_pedidos['data_ida'];
$volta = $dados_pedidos['data_volta'];
$qntd_pessoas = $dados_pedidos['quantidade_pessoas'];
$bagagem_despacho = $dados_pedidos['bagagem_despacho'];
?>


    <form method="post">
      <h1>Detalhes da venda</h1>

     
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
          <td> <?php echo "$volta";?></td>
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
          <td>situacao</td>
          <td><?php echo "$situacao";?> </td>
        </tr>
        <tr>
          <td>Email Painel</td>
          <td><?php echo "$email_painel";?> </td>
        </tr>
        <tr>
          <td>
            <label>
              <div align="center">
                <input type='hidden' name='id_pedido' id='id_pedido'value='<?php  echo $id_cliente?>'/>
                <input type="submit" name="aceitar" id="button_aceitar" value="SUCESSO" formaction="aceitar.php"  />
              </div>
            </label>
          </td>
            <td>
              <label>
                <div align="center">
                  <input type='hidden' name='id_cliente' id='id_cliente'value='<?php  echo $id_cliente?>'/>
                <input type="submit" name="recusar" id="button_recusar" value="FALHA" formaction="recusar.php" />
                  </button>
                </div>
              </label>
            </td>
        </tr>
      </table>
      
    </form>
<br>
<br>
    <?php

    }
?>
  </body>
</html>
    </section>

  

    <script src="js/fastclick.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/fixed-responsive-nav.js"></script>
  </body>
</html>
