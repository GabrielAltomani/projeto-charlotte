<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Editar</title>

    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/editar.css" />
    <link rel="stylesheet" href="css/alertBox.css" />
  </head>
  <body>
    <header>
      <div class="button-back">
        <a id="botaoVoltar" href="#">
          <img src="assets/voltar.png" alt="Botão de voltar" />
        </a>
      </div>

      <div class="title-edit">
        <h1>Editar Perfil</h1>
      </div>
    </header>

    <div class="center">
      <form action="">

      <?php 
        require_once "db_connection.php";
        session_start();

        $id=$_SESSION["id"];
        $nome=$_SESSION["nome"];
        $email=$_SESSION["email"];
        $senha=$_SESSION["senha"];
      ?>


        <div class="txt_field">
          <input type="text" id="inputNome" value="<?php echo $nome; ?>" required />
          <label>Nome de usuário</label>
        </div>
        <div class="txt_field">
          <input type="email" id="inputEmail" value="<?php echo $email; ?>" readonly />
          <label>Email</label>
        </div>
        <div class="txt_field">
          <div class="senha">
            <input type="password" id="logPassword" value="<?php echo $senha; ?>" readonly />
            <label>Senha</label>
            <div class="aye-area">
              <div class="aye-box" onclick="myLogPass()">
                <i class="fa-regular fa-aye" id="aye"><img src="assets/aye.png" alt=""></i>
                <i class="fa-regular fa-aye-slash" id="aye-slash"><img src="assets/aye-slash.png" alt=""></i>
              </div>
            </div>
          </div>
        </div>
        <br>
        <a href="redef_senha.html"><div class="pass">Redefinir sua senha?</div></a>
        <div class="but">
          <div class="sub">
            <input type="submit" value="SALVAR" id="botao_salvar"/>
          </div>
          
          <div class="signup-link" id="sair_link">
            <a href="login.html"><input type="button" value="SAIR"></a>
          </div>
          
          <div class="signup-link" id="excluir_link">
            <a href="login.html"><input type="button" value="EXCLUIR CONTA"></a>
          </div>
        </div>
      </form>
    </div>

    <footer>
      <!-- Overlay para alertas -->
      <div id="alertOverlay" class="overlay">
        <!-- Caixa de alerta -->
        <div id="alertBox" class="alert-box">
          <h2 class="alert-title">Atenção</h2>
          <p class="alert-message">
          Deseja sair da sua conta?
          </p>
          <!-- Botão para cancelar o alerta -->
          <button id="cancelButton" class="alert-button">Cancelar</button>
          <!-- Botão para confirmar o alerta -->
          <button id="confirmButton" class="alert-button">Sim</button>
        </div>
      </div>

      <!-- Overlay para alertas -->
      <div id="alertOverlay2" class="overlay">
        <!-- Caixa de alerta -->
        <div id="alertBox2" class="alert-box">
          <h2 class="alert-title">Atenção</h2>
          <p class="alert-message">
            
          </p>
          <!-- Botão para cancelar o alerta -->
          <button id="entendiButton" class="alert-button">Entendi</button>
        </div>
      </div>

      <div id="alertOverlay3" class="overlay">
        <!-- Caixa de alerta -->
        <div id="alertBox3" class="alert-box">
          <h2 class="alert-title">Atenção</h2>
          <p class="alert-message">
            Deseja excluir esta conta?
          </p>
          <!-- Botão para cancelar o alerta -->
          <button id="cancelButton2" class="alert-button">Cancelar</button>
          <!-- Botão para confirmar o alerta -->
          <button id="confirmButton2" class="alert-button">Sim</button>
        </div>
      </div>
    </footer>

    

    <script src="js/page-back.js"></script>
    <script src="js/view-password.js"></script>
    <script src="js/editar.js"></script>
  </body>
</html>
