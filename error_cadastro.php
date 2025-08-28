<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>NaneMilhas</title>

  <!-- Informações do autor e responsividade -->
  <meta name="author" content="Adtile">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Importa o CSS de login -->
  <link rel="stylesheet" href="./css/login.css">
</head>
<body>

  <!-- Container principal -->
  <div class="login-page">

    <!-- Bloco do formulário -->
    <div class="form">

      <!-- Mensagem de erro exibida quando ocorre falha no cadastro -->
      <div align="center">
        <b><h2>ERRO NO CADASTRO</h2></b>
      </div>

      <!-- Imagem ilustrativa / logo -->
      <div align="center">
        <img src="insta.png" height="150" width="150">
      </div>

      <br>

      <!-- Formulário de cadastro -->
      <!-- onsubmit chama JS para validar se as senhas coincidem -->
      <!-- action envia os dados para cadastro2.php -->
      <form class="login-form" onsubmit="return verificaSenhas()" action="cadastro2.php" method="post">
        
        <!-- Campo para nome -->
        <input type="text" placeholder="NOME" name="nome" id="nome" required />

        <!-- Campo para senha -->
        <input type="password" id="senha" name="senha" placeholder="SENHA" required>

        <!-- Campo para confirmar senha -->
        <input type="password" id="confirmar_senha" placeholder="CONFIRMAR SENHA" name="confirmar_senha" required>

        <!-- Campo para e-mail -->
        <input type="text" placeholder="EMAIL" name="email" id="email" required />

        <!-- Botão de criar conta -->
        <button>Criar Conta</button>

        <!-- Link para login caso já seja cadastrado -->
        <p class="message">Já é registrado? <a href="login.php">Entre aqui</a></p>
      </form>

      <!-- Script JS para validar se as senhas batem -->
      <script>
        function verificaSenhas() {
          var senha = document.getElementById("senha").value;
          var confirmar_senha = document.getElementById("confirmar_senha").value;

          if (senha != confirmar_senha) {
            alert("As senhas não são iguais!");
            return false; // bloqueia envio
          }

          return true; // permite envio
        }
      </script>
    </div>
  </div>

</body>
</html>
