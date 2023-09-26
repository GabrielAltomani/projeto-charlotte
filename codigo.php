<?php 
require_once "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $token_digitado = $_POST['codigo'];
    date_default_timezone_set('America/Sao_Paulo');
    $currentTimestamp = date('Y-m-d H:i:s');
    $sql = "SELECT cod_usuario FROM tb_token WHERE token = :token AND tempo_token > :tempo_token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":token", $token_digitado, PDO::PARAM_STR);
    $stmt->bindValue(":tempo_token", $currentTimestamp, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        echo 'Token válido!';
        header("Location: redefinir-senha.html");
        
        $sql_delete = "DELETE FROM tb_token WHERE token = ?";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->bindValue(1, $token_digitado, PDO::PARAM_STR);
        $stmt_delete->execute();
    } else {
        echo 'Token inválido ou expirado!';
    }
}
?>
