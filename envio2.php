<?php
session_start(); // Inicia a sessão se ainda não estiver iniciada

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');
require_once "db_connection.php";
ob_start();

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];
// Consulta SQL para obter o ID do usuário com base no email
$sql = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = :email and ativo = 1 LIMIT 1";
$stmt_id = $pdo->prepare($sql);
$stmt_id->bindValue(":email", $email, PDO::PARAM_STR);
$stmt_id->execute();


if ($stmt_id->execute()) {
    $row = $stmt_id->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user_id = $row['id_usuario'];

        // Armazene o ID do usuário em uma variável de sessão
        
        
        $_SESSION['user_id'] = $user_id;

        $token = substr(md5(uniqid(rand(), true)), 0, 6);
        date_default_timezone_set('America/Sao_Paulo');
        $expiration_time = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $sql_token = "INSERT INTO tb_token (cod_usuario, token, tempo_token) VALUES (?, ?, ?)";
        $stmt_token = $pdo->prepare($sql_token);
        $stmt_token->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt_token->bindParam(2, $token, PDO::PARAM_STR);
        $stmt_token->bindParam(3, $expiration_time, PDO::PARAM_STR);
        
        if ($stmt_token->execute()) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'charlottelixeira@gmail.com';                     //SMTP username
                $mail->Password   = 'kopmzunhzvvxeauk';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to pdonect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = 'UTF-8';
            
                //Recipients
                $mail->setFrom('charlottelixeira@gmail.com');
                $mail->addAddress($_POST['email']);     //Add a recipient  Name is optional
                $mail->addReplyTo('charlottelixeira@gmail.com');
            
                //pdotent
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Redefinição de senha';
                $mail->Body = '
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <meta charset="UTF-8">
                                <title>Redefinição de Senha</title>
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #f5f5f5;
                                    }
                                    .container {
                                        max-width: 600px;
                                        margin: 0 auto;
                                        padding: 20px;
                                        background-color: #fff;
                                        border-radius: 5px;
                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                    }
                                    .header {
                                        background-color: #007bff;
                                        color: #fff;
                                        text-align: center;
                                        padding: 10px;
                                    }
                                    .content {
                                        padding: 20px;
                                    }
                                    .code {
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-align: center;
                                        margin-top: 20px;
                                    }
                                    .footer {
                                        text-align: center;
                                        margin-top: 20px;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    <div class="header">
                                        <h2>Redefinição de Senha</h2>
                                    </div>
                                    <div class="content">
                                        <p>Olá,</p>
                                        <p>Você está recebendo este e-mail porque solicitou a redefinição de senha da sua conta.</p>
                                        <p>Para realizar esta ação, utilize o seguinte código:</p>
                                        <p class="code">'.$token.'</p>
                                        <p>Este código é válido por 15 minutos a partir do momento do envio deste e-mail.</p>
                                        <p>Se você não solicitou a redefinição de senha, pode ignorar este e-mail com segurança.</p>
                                    </div>
                                    <div class="footer">
                                        <p>Este é um e-mail automático. Por favor, não responda a este e-mail.</p>
                                    </div>
                                </div>
                            </body>
                            </html>
                            
                        ';
                $mail->AltBody = 'Redefinição de senha';
        
                if($mail->send()) {
                    
                    header("Location: inserir-codigo.html");
                    exit;
                } else {
                    echo 'Email não enviado';
                }
            } catch (Exception $e) {
                echo "erro ao enviar o email: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Erro ao inserir o token: ' . $stmt_token->errorInfo()[2];
        }
    } else {
        echo "usuario não encontrado com esse email";
    }
} else {
    echo 'Erro ao executar a consulta: ' . $stmt_id->errorInfo()[2];
}
?>