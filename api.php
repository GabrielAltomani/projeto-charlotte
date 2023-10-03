<?php
header('Content-Type: application/json');
require_once 'db_connection.php';

// Verifique se a solicitação é uma solicitação POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados JSON do corpo da solicitação
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Verifique se o campo 'contador' está presente no JSON recebido
    if (isset($data['contador'])) {
        $contador = $data['contador'];

        // Execute uma consulta SQL para inserir o contador no banco de dados
        $sql = "INSERT INTO tb_lixeira (quantidade) VALUES (:contador)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':contador', $contador, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(array('mensagem' => 'Dados inseridos com sucesso.'));
        } catch(PDOException $e) {
            echo json_encode(array('erro' => 'Erro ao inserir dados: ' . $e->getMessage()));
        }
    } else {
        echo json_encode(array('erro' => 'Campo "contador" não foi enviado no JSON.'));
    }
} else {
    echo json_encode(array('erro' => 'Método de solicitação não suportado.'));
}
?>
