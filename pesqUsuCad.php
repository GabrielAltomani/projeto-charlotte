<?php
        require_once "db_connection.php";

        $email = $_GET['ep'];
        //$email="helo@email.com";
        //echo "valor do email no pesqUsu $email";

        $comandoSql="select id_usuario, email_usuario, nome_usuario, senha from tb_usuario where 
                     email_usuario='$email'";

        $resultado= $pdo->query($comandoSql);
        
        if($linha = $resultado->fetch(PDO::FETCH_ASSOC)){
           echo "$linha[id_usuario]";
        }

?>
    