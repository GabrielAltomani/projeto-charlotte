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