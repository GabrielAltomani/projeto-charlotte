<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/home-responsive.css">
</head>

<body>
    <div class="leaderboard">
        <h1>Ranking Geral</h1>
        <ol>
            <?php
                // Incluindo o arquivo de conexão para estabelecer conexão com o banco de dados
                require_once "db_connection.php";

                // Consulta SQL
                $sql = "select u.nome_usuario, count(l.id_lixo) as pontuacao
                        from tb_usuario u
                        inner join tb_lixo_descarte l on u.id_usuario = l.cod_usuario
                        and u.ativo=1
                        group by u.id_usuario
                        order by pontuacao desc";

                // Executando a consulta SQL e armazenando o resultado na variável $result
                $result = $pdo->query($sql);

                // Verificando se a consulta foi bem-sucedida
                if ($result) {
                    $rank = 1; // Variável para controlar o número de classificação
                    $counter = 0;
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {       // Loop para percorrer cada linha de resultado
                        $counter++; 
                        $nome = $row["nome_usuario"]; // Obtendo o nome do usuário da linha atual
                        $pontuacao = $row["pontuacao"]; // Obtendo a pontuação do usuário da linha atual

                        $extraClass = '';
                        if ($counter == 1) {
                            $extraClass = '-1-lugar';
                        } if ($counter == 2) {
                            $extraClass = '-2-lugar';
                        } if ($counter == 3) {
                            $extraClass = '-3-lugar';
                        }

                        // Exibindo as informações do líder formatadas em HTML
                        echo "
                            <ul class='linha-rank'>
                                <li class='rank-number-li$extraClass'>
                                    <span class='rank-number'>$rank</span>
                                </li>
                                <li class='rank-content'>
                                    <mark>$nome</mark>
                                    <small>$pontuacao</small>
                                </li>
                            </ul>
                        ";
                

                        $rank++; // Incrementando o número de classificação
                    }
                } else {
                    // Exibindo uma mensagem de erro caso a consulta não tenha sido bem-sucedida
                    echo "Erro na consulta: " . $pdo->errorInfo()[2];
                }
            ?>
        </ol>
    </div>
    <footer>
        <div class="actions">
            <!-- Botão para realizar descarte -->
            <button type="button" class="descarte" id="descarte">
                Realizar Descarte
            </button>
            <!-- Overlay para alertas -->
            <div id="alertOverlay" class="overlay">
                <!-- Caixa de alerta -->
                <div id="alertBox" class="alert-box">
                    <h2 class="alert-title">Atenção</h2>
                    <p class="alert-message">
                        Começou a contagem para você realizar o descarte. Se quiser
                        cancelar, clique novamente no botão.
                    </p>
                    <!-- Botão para cancelar o alerta -->
                    <button id="cancelButton" class="alert-button">Cancelar</button>
                    <!-- Botão para confirmar o alerta -->
                    <button id="confirmButton" class="alert-button">Entendi</button>
                </div>
            </div>
            <!-- Link para a página de edição de perfil -->
            <a href="editar.php">
                <button type="button" class="editar">Editar Perfil</button>
            </a>
        </div>
    </footer>

    <?php 
        // Inclua o arquivo de conexão com o banco de dados
        require_once "db_connection.php";

        // Verifique se o id foi passado via GET
        if(isset($_GET["id"])) {
            // Obtém o id da URL de forma segura
            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
            
            // Prepara a consulta SQL usando um Prepared Statement
            $stmt = $pdo->prepare("SELECT nome_usuario, email_usuario, senha FROM tb_usuario WHERE id_usuario = :id");
            
            // Atribui o valor ao parâmetro na consulta
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Executa a consulta
            if ($stmt->execute()) {
                // Verifica se encontrou algum resultado
                if($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                    // Inicia a sessão
                    session_start();
            
                    // Define as variáveis de sessão
                    $_SESSION["id"] = $id;
                    $_SESSION["nome"] = $linha["nome_usuario"];
                    $_SESSION["email"] = $linha["email_usuario"];
                    $_SESSION["senha"] = $linha["senha"];

                    $userData = array(
                        'id' => $_SESSION["id"],
                        'nome' => $_SESSION["nome"],
                        'email' => $_SESSION["email"]
                    );
                
                    // Converte o array de dados do usuário em JSON
                    $userDataJSON = json_encode($userData);

                    // Inclui o script JavaScript para definir a variável userData
                    echo "<script>var userData = $userDataJSON;</script>";
                } else {
                    // Usuário não encontrado, redirecione ou mostre uma mensagem de erro
                    exit();
                }
            } else {
                // Erro ao executar a consulta, redirecione ou mostre uma mensagem de erro
                exit();
            }
        } else {
            // id não especificado na URL, redirecione ou mostre uma mensagem de erro
            exit();
        }
                
    ?>
    <script src="js/number-rank.js"></script>
    <script src="js/descarte.js"></script>
    <script src="js/update-leaderboard.js"></script>
</body>
</html>