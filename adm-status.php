<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Status lixeira</title>

    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/adm-status.css" />
  </head>
  <body>
    <div class="leaderboard">
      <h1>Status lixeira</h1>
      <ol>
        <?php
          // Incluindo o arquivo de conexão para estabelecer conexão com o banco de dados
          require_once "db_connection.php";

          try {
            // Consulta SQL para selecionar os dados da tabela
            $sql = "select id_lixeira, quantidade, cheio, data_cheio 
            from tb_lixeira
            order by id_lixeira desc";

            // Executa a consulta usando o objeto $pdo
            $result = $pdo->query($sql);

            // Verifica se há resultados
            if ($result->rowCount() > 0) {
              // Loop através dos resultados e exibe-os
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
              echo "<ul>";
              echo "<li>ID: " . $row["id_lixeira"] . "</li>";
              echo "<li>Quantidade: " . $row["quantidade"] . "</li>";
              echo "<li>Cheio: " . ($row["cheio"] ? "Sim" : "Não") . "</li>";

              // Formata a data para o padrão brasileiro
              $dataFormatada = date("d/m/Y    H:i:s", strtotime($row["data_cheio"]));
              echo "<li>Data: " . $dataFormatada . "</li>";

              echo "</ul>";
            }
            } else {
              echo "Nenhum resultado encontrado.";
            }
          } catch (PDOException $e) {
           echo "Erro na consulta: " . $e->getMessage();
          }
        ?>
      </ol>
    </div>
    <footer>
      <div class="actions">
        <a href="adm-ranking.php"><button type="button" class="ranking">Ranking</button></a>
      </div>
    </footer>
  </body>
</html>
