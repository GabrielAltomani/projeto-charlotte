<?php
//definindo local, banco, usuario e senha usando PDO
try {
    // criando a conexão com o banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=bd_charlotte', 'root', '');

    //deferinedoo atributo ao pde onde todos os erros gerados devem ser tratados como excecao 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexao ok";
    
} catch(PDOException $e) {
     echo "Erro na conexao: " . $e->getMessage();
   }
?>