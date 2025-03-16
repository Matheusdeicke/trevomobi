<?php
// Importa as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carrega o autoloader do Composer
require '../vendor/autoload.php';  // Ajuste o caminho se necessário

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $nome = trim($_POST["nome"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensagem = trim($_POST["mensagem"]);

    // Verifica se algum campo está vazio
    if (empty($nome) || empty($email) || empty($mensagem)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Configuração do email
    $destinatario = "deickematheus@gmail.com"; // Substitua pelo email desejado
    $assunto = "Contato do site de $nome";

    // Monta o corpo do email
    $corpo  = "Nome: $nome\n";
    $corpo .= "Email: $email\n\n";
    $corpo .= "Mensagem:\n$mensagem\n";

    // Cria uma instância do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';            // Exemplo: Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'xxxxx@gmail.com';         // Seu email
        $mail->Password   = 'xxxxxx';                   // Sua senha ou senha de aplicativo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Define remetente e destinatário
        $mail->setFrom('xxxxx@gmail.com', 'Matheus');  // Você pode fixar o remetente ou usar os dados do formulário
        $mail->addAddress($destinatario);

        // Configura o conteúdo do email
        $mail->isHTML(false);
        $mail->Subject = $assunto;
        $mail->Body    = $corpo;

        // Tenta enviar o email
        $mail->send();

        // Redireciona para a página de agradecimento
        header("Location: obrigado.html");
        exit;
    } catch (Exception $e) {
        echo "Ocorreu um erro ao enviar sua mensagem. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Método inválido.";
}
?>
