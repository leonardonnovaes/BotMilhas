<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>NaneMilhas</title>

  <!-- Meta tags para responsividade -->
  <meta name="author" content="Adtile">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Importa o CSS externo -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Container principal da página de login/cadastro -->
  <div class="login-page">

    <!-- Bloco do formulário -->
    <div class="form">

      <!-- Mensagem de erro quando o e-mail já está cadastrado -->
      <div align="center">
        <b><h2>EMAIL JÁ CADASTRADO</h2></b>
      </div>

      <!-- Logo / Imagem ilustrativa -->
      <div align="center">
        <img src="insta.png" height="150" width="150">
      </div>

      <br>

      <!-- Formulário de cadastro -->
      <!-- onsubmit chama a função JS que verifica se as senhas conferem -->
      <!-- action define o arquivo que processa o cadastro (cadastro2.php) -->
      <form class="login-form" onsubmit="return verificaSenhas()" action="cadastro2.php" method="post">
        
        <!-- Campo para nome -->
        <input type="text" placeholder="NOME" name="nome" id="nome" required/>

        <!-- Campo para senha -->
        <input type="password" id="senha" name="senha" placeholder="SENHA" required>

        <!-- Campo para confirmar senha -->
        <input type="password" id="confirmar_senha" placeholder="CONFIRMAR SENHA" name="confirmar_senha" required>

        <!-- Campo para e-mail -->
        <input type="text" placeholder="EMAIL" name="email" id="email" required/>

        <!-- Botão de enviar -->
        <button>Criar Conta</button>

        <!-- Link para login caso já tenha conta -->
        <p class="message">Já é registrado? <a href="login.php">Entre aqui</a></p>
      </form>

      <!-- Script JS para validar se as senhas são iguais -->
      <script>
        function verificaSenhas() {
          var senha = document.getElementById("senha").value;
          var confirmar_senha = document.getElementById("confirmar_senha").value;

          // Verifica se os dois campos de senha batem
          if (senha != confirmar_senha) {
            alert("As senhas não são iguais!");
            return false; // Impede envio do formulário
          }

          return true; // Permite envio do formulário
        }
      </script>
    </div>
  </div>

</body>
</html>
