
        <?php
        require_once "db_connection.php";

        $nome=filter_input(INPUT_POST,'nc',FILTER_SANITIZE_SPECIAL_CHARS);
        $email=filter_input(INPUT_POST,'ec',FILTER_VALIDATE_EMAIL);
        $senha=filter_input(INPUT_POST,'sc',FILTER_SANITIZE_SPECIAL_CHARS);
        //echo "$nome $email $senha";

        $comandoSql="insert into tb_usuario
            (nome_usuario, email_usuario, senha)
             values 
             ('$nome', '$email', '$senha');";

             $resultado= $pdo->query($comandoSql);
        
        if($resultado==true)
           echo "Cadastrado com sucesso";
    
        ?>
    

