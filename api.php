<?php
header('Content-Type: application/json');

// Defina a conexão com o banco de dados usando PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bd_charlotte', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(array('erro' => 'Erro na conexão: ' . $e->getMessage()));
    exit;
}

// Verifique se a solicitação é uma solicitação POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se o campo 'contador' está presente na solicitação POST
    if (isset($_POST['contador'])) {
        $contador = $_POST['contador'];
        
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
        echo json_encode(array('erro' => 'Campo "contador" não foi enviado na solicitação.'));
    }
} else {
    echo json_encode(array('erro' => 'Método de solicitação não suportado.'));
}
?>
