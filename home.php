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

                // Fechando a conexão com o banco de dados
                $pdo = null;
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
            <a href="editar.html">
                <button type="button" class="editar">Editar Perfil</button>
            </a>
        </div>
    </footer>
    <script src="js/number-rank.js"></script>
    <script src="js/descarte.js"></script>
    <script src="js/update-leaderboard.js"></script>
</body>
</html>