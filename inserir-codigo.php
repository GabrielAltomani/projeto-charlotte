<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Inserir codigo</title>

    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/login-responsive.css" />
  </head>
  <body>
    <header>
      <div class="button-back">
        <a id="botaoVoltar" href="#">
          <img src="assets/voltar.png" alt="Botão de voltar" />
        </a>
      </div>
    </header>

    <div class="center">
      <h1>Esqueceu sua</h1>
      <h1>Senha?</h1>
      <form action="envio.php" method="post">
        <div class="txt_field">
          <input type="text" id="codigo" name="codigo" required />
          <label>Digite seu código</label>
          <span></span>
        </div>
        <div class="sub">
          <input type="submit" value="enviar" name="enviar"/>
        </div>
      </form>
    </div>

    <script src="js/page-back.js"></script>
  </body>
</html>

<!-- VERIFICANDO SE O TOKEN DIGITADO ESTÁ CORRETO -->

<?php 
require_once "bd_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $token_digitado = $_POST['codigo'];
    // echo"$token_digitado";
    date_default_timezone_set('America/Sao_Paulo');
    $currentTimestamp = date('Y-m-d H:i:s');
    $sql = "SELECT cod_usuario FROM tb_token WHERE token = ? AND tempo_token > ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $token_digitado, $currentTimestamp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo 'Token válido!';
        header("Location: form_nova_senha.php");
        
        $sql_delete = "DELETE FROM tb_token WHERE token = ?";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bind_param("s", $token_digitado);
        $stmt_delete->execute();
    } else{
        echo 'Token inválido ou expirado!';
    }
}
?>