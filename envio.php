<?php
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');
require_once "db_connection.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// PEGANDO O ID DESSE USUARIO (EMAIL)
$sql_id = "SELECT id_usuario FROM tb_usuario WHERE email = ? LIMIT 1";
$stmt_id = $con->prepare($sql_id);
$stmt_id->bind_param("s", $email);

if ($row) {

    $user_id = $row['id_usuario'];
    $token = substr(md5(uniqid(rand(), true)), 0, 4);
    date_default_timezone_set('America/Sao_Paulo');
    $expiration_time = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $sql_token = "INSERT INTO tb_token (cod_usuario, token, tempo_token) VALUES (?, ?, ?)";
    $stmt_token = $con->prepare($sql_token);
    $stmt_token->bind_param("iss", $user_id, $token, $expiration_time);

    
    if (isset($_POST['enviar'])) {
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
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';
        
            //Recipients
            $mail->setFrom('charlottelixeira@gmail.com');
            $mail->addAddress($_POST['email']);     //Add a recipient  Name is optional
            $mail->addReplyTo('charlottelixeira@gmail.com');
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperação de senha';
            $mail->Body = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Recuperação de Senha</title>
                    </head>
                    <body>
                        <p>Olá,</p>
                        
                        <p>Você está recebendo este e-mail porque solicitou a recuperação de senha da sua conta.</p>
                        
                        <p>Para redefinir sua senha, utilize o seguinte código:</p>
                        
                        
                        
                        <p>Este código é válido por 15 minutos a partir do momento do envio deste e-mail.</p>
                        
                        <p>Se você não solicitou a recuperação de senha, pode ignorar este e-mail com segurança.</p>
                        
                    </body>
                    </html>
                    ';
            $mail->AltBody = 'Recuperação de senha';
    
            if($mail->send()) {
                header('Location: redefinir-senha.php');
                exit;
            } else {
                echo 'Email não enviado';
            }
        } catch (Exception $e) {
            echo "erro ao enviar o email: {$mail->ErrorInfo}";
        }
    } else {
        echo "erro ao enviar o email, acesso não foi por formulario";
    }
} else {
    echo "usuario não encontrado com esse email";
}

?>