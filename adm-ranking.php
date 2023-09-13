<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Ranking ADM</title>

    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/adm-ranking.css" />
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
              // Loop para percorrer cada linha de resultado
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $nome = $row["NOME_USUARIO"]; // Obtendo o nome do usuário da linha atual
                $pontuacao = $row["PONTUACAO"]; // Obtendo a pontuação do usuário da linha atual

                // Exibindo as informações do líder formatadas em HTML
                echo "<li>
                  <span class='rank-number'>$rank</span>
                  <mark>$nome</mark>
                  <small>$pontuacao</small>
                </li>";

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
        <a href="adm-status.php"><button type="button" class="status">Status Lixeira</button></a>
      </div>
    </footer>

    <script src="js/number-rank.js"></script>
  </body>
</html>
