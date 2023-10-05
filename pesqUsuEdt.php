<?php
        require_once "db_connection.php";
        session_start();

        $email = $_GET['ep'];
        $id = $_SESSION["id"];
        //$email="helo@email.com";
        //echo "valor do email no pesqUsu $email";

        $comandoSql="select id_usuario, email_usuario, nome_usuario, senha from tb_usuario where 
                     email_usuario='$email' and id_usuario!=$id and ativo=1";

        $resultado= $pdo->query($comandoSql);
        
        if($linha = $resultado->fetch(PDO::FETCH_ASSOC)){
           echo "$linha[id_usuario]";
        }

?>
    