<?php
//recebendo o email do formulário
$email = $_POST['ec'];
//validando o email
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Email válido";    
}

?>
