<!DOCTYPE html>
<html lang="pt" >
<head >
  <meta charset="UTF-8">
  <title>NaneMilhas</title>
  <meta charset="utf-8">
  

  <meta name="author" content="Adtile">
    <meta name="viewport" content="width=device-width,initial-scale=1">
   
  <link rel="stylesheet" href="./css/login.css" >

<div class="login-page" >
  <h1 align="center">ERRO NO LOGIN<br>TENTE NOVAMENTE</h1>
  <div class="form" >
    <div align="center"><img src="./icons/nane.png"  height="150" width="150"></div>
    <br>

    <form class="login-form" action='autenticar.php' method="post"> 
      <input type="text" placeholder="Seu email"id='email' name='email'/>
      <input type="password" placeholder="senha"id='senha' name ='senha'/>
      <button>ENTRAR</button>
      <p class="message">Não tenho conta <a href="cadastro.php">Clica aqui</a></p>
     </form>
  </div>
</div>