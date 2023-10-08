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
            $sql = "select u.nome_usuario, count(l.id_lixo) as pontuacao
                    from tb_usuario u
                    inner join tb_lixo_descarte l on u.id_usuario = l.cod_usuario
                    where u.ativo = 1
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
        <a href="adm-status.php"><button type="button" class="status">Status Lixeira</button></a>
      </div>
    </footer>

    <script src="js/number-rank.js"></script>
    <script src="js/update-leaderboard.js"></script>
  </body>
</html>
