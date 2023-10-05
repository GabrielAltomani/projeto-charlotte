<?php
    /*1- realizando a conexao com o banco de dados */
    require_once "db_connection.php";
    session_start();
    
    /*2- pegando os dados vindos do formulario e armazenando em variaveis */
    $id = $_SESSION["id"];
	  
    /*3- criando o comando sql para alteracao do registro */
	$comandoSql="update tb_usuario set ativo=0 where id_usuario=$id";
	
	/*4- executando o comando sql */
	$resultado= $pdo->query($comandoSql);
	
	/*5- verificando se o comando sql foi executado */
     if($resultado==true)
		  echo "Excluido com sucesso";

  ?>