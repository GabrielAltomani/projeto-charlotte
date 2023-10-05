<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/home.css" />
</head>

<body>
    <div class="leaderboard">
        <h1>Ranking Geral</h1>
        <ol>
            <?php
                // Incluindo o arquivo de conexão para estabelecer conexão com o banco de dados
                require_once "db_connection.php";

                // Consulta SQL
                $sql = "SELECT U.NOME_USUARIO, COUNT(L.ID_LIXO) AS PONTUACAO
                        FROM TB_USUARIO U
                        INNER JOIN TB_LIXO_DESCARTE L ON U.ID_USUARIO = L.COD_USUARIO
                        where U.ativo=1
                        GROUP BY U.ID_USUARIO
                        ORDER BY PONTUACAO DESC";

                // Executando a consulta SQL e armazenando o resultado na variável $result
                $result = $pdo->query($sql);

                // Verificando se a consulta foi bem-sucedida
                if ($result) {
                    $rank = 1; // Variável para controlar o número de classificação
                    $counter = 0;
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {       // Loop para percorrer cada linha de resultado
                        $counter++; 
                        $nome = $row["NOME_USUARIO"]; // Obtendo o nome do usuário da linha atual
                        $pontuacao = $row["PONTUACAO"]; // Obtendo a pontuação do usuário da linha atual

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
            $stmt->execute();
        
            // Verifica se encontrou algum resultado
            if($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                $nome = $linha["nome_usuario"];
                $email = $linha["email_usuario"];
                $senha = $linha["senha"];
        
                // Inicia a sessão
                session_start();
        
                // Define as variáveis de sessão
                $_SESSION["id"] = $id;
                $_SESSION["nome"] = $nome;
                $_SESSION["email"] = $email;
                $_SESSION["senha"] = $senha;
            } else {
                // Usuário não encontrado, redirecione ou mostre uma mensagem de erro
            }
        } else {
            // id não especificado na URL, redirecione ou mostre uma mensagem de erro
        }
        
    ?>

    <script src="js/number-rank.js"></script>
    <script src="js/descarte.js"></script>
    <script src="js/update-leaderboard.js"></script>
</body>
</html>