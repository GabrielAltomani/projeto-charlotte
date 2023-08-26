<?php
require_once "db_connection.php"; // Inclui o arquivo de conexão

$sql = "SELECT U.NOME_USUARIO, COUNT(L.ID_LIXO) AS PONTUACAO
        FROM TB_USUARIO U
        INNER JOIN TB_LIXO_DESCARTE L ON U.ID_USUARIO = L.COD_USUARIO
        GROUP BY U.ID_USUARIO
        ORDER BY PONTUACAO DESC";

$result = $pdo->query($sql);

if ($result) {
    $rank = 1;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $nome = $row["NOME_USUARIO"];
        $pontuacao = $row["PONTUACAO"];

        echo "<li>
                <span class='rank-number'>$rank</span>
                <mark>$nome</mark>
                <small>$pontuacao</small>
              </li>";

        $rank++;
    }
} else {
    echo "Erro na consulta: " . $pdo->errorInfo()[2];
}

$pdo = null;
?>
