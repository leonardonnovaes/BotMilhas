<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'bot';
$conn = mysqli_connect($servidor,$usuario,$senha,$banco);

if(!$conn){
    # echo "error!";
}
else{
    # echo "ok!";
}




?>