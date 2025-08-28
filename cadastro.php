<!DOCTYPE html>
<html lang="pt" >
<head>
  <meta charset="UTF-8">
  <title>NaneMilhas</title>

  <!-- Metadados da página -->
  <meta name="author" content="Adtile">
  <meta name="viewport" content="width=device-width,initial-scale=1">
   
  <!-- Importa o arquivo CSS -->
  <link rel="stylesheet" href="./css/login.css">

  <!-- Início do conteúdo da página -->
<div class="login-page">
  <div class="form">

    <!-- Logo centralizada -->
    <div align="center"><img src="./icons/nane.png"  height="150" width="150"></div>
    <br>

    <!-- Formulário de cadastro -->
    <!-- onsubmit chama a função JS verificaSenhas() -->
    <!-- action envia os dados para cadastro2.php -->
    <!-- method="post" garante segurança no envio -->
    <form class="login-form" onsubmit="return verificaSenhas()" action="cadastro2.php" method="post">
      
      <!-- Campo para o nome -->
      <input type="text" placeholder="NOME" name="nome" id="nome"/>
      
      <!-- Campo para senha -->
      <input type="password" id="senha" name="senha" placeholder="SENHA" required>
      
      <!-- Campo para confirmar senha -->
      <input type="password" id="confirmar_senha" placeholder="CONFIRMAR SENHA" name="confirmar_senha" required>
      
      <!-- Campo para e-mail -->
      <input type="text" placeholder="EMAIL" name="email" id ="email"/>
      
      <!-- Botão de envio -->
      <button>Criar Conta</button>

      <!-- Mensagem com link para login -->
      <p class="message">Já é registrado <a href="login.php">entre aqui</a></p>
    </form>
   
<!-- Script em JavaScript para validar senha -->
<script>
  function verificaSenhas() {
    // Pega os valores digitados nos dois campos de senha
    var senha = document.getElementById("senha").value;
    var confirmar_senha = document.getElementById("confirmar_senha").value;

    // Se as senhas forem diferentes, alerta o usuário e bloqueia o envio
    if (senha != confirmar_senha) {
      alert("As senhas não são iguais!");
      return false;
    }

    // Se forem iguais, permite o envio do formulário
    return true;
  }
</script>
  </div>
</div>
