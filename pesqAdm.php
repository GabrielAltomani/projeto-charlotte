<?php
        require_once "db_connection.php";

        $email = $_GET['ep'];
        $senha = $_GET['sc'];

        $comandoSql="select id_adm, email_adm, nome_adm, senha_adm from tb_adm where 
                     email_adm='$email' and senha_adm='$senha'";
        $resultado= $pdo->query($comandoSql);
           
        if($linha = $resultado->fetch(PDO::FETCH_ASSOC)){
           echo "$linha[id_adm]";
        }

?>
    