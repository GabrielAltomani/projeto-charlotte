<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');
    require_once 'db_connection.php';
    
    // Verifique se o campo 'contador' está presente no JSON recebido
    // Recebe o ID do usuário da URL
    // Armazene o ID do usuário na variável de sessão
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 
        $idUsuario = $_GET['id_usuario'];
        $_SESSION['id_usuario'] = $idUsuario;
        echo json_encode(array('mensagem' => 'id armazenado'));
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        $idUsuario = $_GET['id_usuario'];
        
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['contador'])) {
            // Receba o contador do corpo da solicitação JSON
            $contador = $data['contador'];
                
            // Execute uma consulta SQL para atualizar a quantidade na tabela tb_lixeira
            $updateSql = "UPDATE tb_lixeira SET quantidade = (:contador) WHERE id_lixeira = '1'";
            // Por exemplo, inserir o ID do usuário na tabela tb_lixo_descarte
            $insertSql = "INSERT INTO tb_lixo_descarte (cod_usuario, data_hora) VALUES (:idUsuario, current_timestamp())";
        
            try {
                $pdo->beginTransaction();

                // Atualize a tabela tb_lixeira
                $stmtUpdate = $pdo->prepare($updateSql);
                $stmtUpdate->bindParam(':contador', $contador, PDO::PARAM_INT);
                $stmtUpdate->execute();

                // Insira na tabela tb_lixo_descarte
                $stmtInsert = $pdo->prepare($insertSql);
                $stmtInsert->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmtInsert->execute();

                // Commit das transações
                $pdo->commit();

                echo json_encode(array('mensagem' => 'Dados inseridos com sucesso.'));
            } catch(PDOException $e) {
                // Se ocorrer um erro, reverta as transações
                $pdo->rollBack();
                echo json_encode(array('erro' => 'Erro ao inserir dados: ' . $e->getMessage()));
            }
        } else {
            echo json_encode(array('erro' => 'Campo "contador" não foi enviado no JSON.'));
        }
    }
?>