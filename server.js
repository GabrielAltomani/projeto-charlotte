const express = require('express');
const bodyParser = require('body-parser');
const session = require('express-session');
const mysql = require('mysql2/promise');

const app = express();
const PORT = 3000;

let usuarioId;

app.use(express.json()); // Middleware para analisar o corpo da solicitação JSON

app.use(bodyParser.json());

// Middleware para permitir requisições de diferentes origens (CORS)
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    res.header('Access-Control-Allow-Headers', 'Content-Type');
  next();
});

// Configuração da sessão
app.use(session({
  secret: 'sua_chave_secreta',
  resave: false,
  saveUninitialized: true
}));

app.get('/charlotte-app/api.js', (req, res) => {
  const { id_usuario } = req.query;
  req.session.id_usuario = id_usuario;
  usuarioId = id_usuario;
  console.log(usuarioId);
  res.json({ mensagem: 'ID do usuário armazenado com sucesso.' });
});

app.post('/charlotte-app/api.js', async (req, res) => {
  const { contador } = req.body;
  const idUsuario = usuarioId;
  console.log(idUsuario);

  if (contador !== undefined && idUsuario !== undefined) {
    try {
      // Configuração do pool de conexões do MySQL
      const pool = mysql.createPool({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'bd_charlotte',
        waitForConnections: true,
        connectionLimit: 10,
        queueLimit: 0
      });

      // Obtenha uma conexão do pool
      const connection = await pool.getConnection();

      // Consulta SQL para atualizar a quantidade na tabela tb_lixeira
      const updateSql = 'UPDATE tb_lixeira SET quantidade = ? WHERE id_lixeira = 1';
      await connection.execute(updateSql, [contador]);

      // Consulta SQL para inserir dados na tabela tb_lixo_descarte
      const insertSql = 'INSERT INTO tb_lixo_descarte (cod_usuario, data_hora) VALUES (?, current_timestamp())';
      await connection.execute(insertSql, [idUsuario]);

      // Libere a conexão de volta para o pool
      connection.release();

      res.json({ mensagem: 'Dados inseridos com sucesso.' });
    } catch (error) {
      console.error(error);
      res.status(500).json({ erro: 'Erro interno do servidor.' });
    }
  } else {
    res.status(400).json({ erro: 'Parâmetros inválidos.' });
  }
});

app.listen(PORT, () => {
  console.log(`Servidor executando na porta ${PORT}`);
});