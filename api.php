<?php
header('Content-Type: application/json');
require_once 'db_connection.php';
session_start();

// Verifique se a solicitação é uma solicitação POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados JSON do corpo da solicitação
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Verifique se o campo 'contador' está presente no JSON recebido
    if (isset($data['contador'])) {
        $contador = $data['contador'];
        
        // Obtenha o ID do usuário da variável de sessão
        $idUsuario = $_SESSION["id"];

        var_dump($contador, $idUsuario);

        // Execute uma consulta SQL para inserir o contador no banco de dados
        $updateSql = "UPDATE tb_lixeira SET quantidade = (:contador) WHERE id_lixeira='1'";
        $insertSql = "INSERT INTO tb_lixo_descarte (COD_USUARIO, DATA_HORA) VALUES (:idUsuario, current_timestamp())";

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
} else {
    echo json_encode(array('erro' => 'Método de solicitação não suportado.'));
}
?>
