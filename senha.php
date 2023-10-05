<?php 
require_once "db_connection.php";
session_start(); // Certifique-se de iniciar a sessão para acessar a variável $_SESSION

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_senha']) && isset($_POST['confirma_senha'])) {
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($nova_senha === $confirma_senha) {
        // Recupere o ID do usuário da variável de sessão
        if (isset($_SESSION['user_id'])) {
            $usuario_id = $_SESSION['user_id'];

            $sql = "UPDATE tb_usuario SET senha = ? WHERE id_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $confirma_senha, PDO::PARAM_STR);
            $stmt->bindParam(2, $usuario_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['mensagemSucesso'] = "Senha redefinida com sucesso!";
                header("Location: login.html");
                exit; // Encerre o script após redirecionar
            } else {
                $_SESSION['mensagemErro'] = "Erro ao redefinir a senha.";
            }
        } else {
            $_SESSION['mensagemErro'] = "ID do usuário não encontrado na sessão.";
        }
    } else {
        $_SESSION['mensagemErro'] = "As senhas não coincidem. Tente novamente.";
    }
}
?>
