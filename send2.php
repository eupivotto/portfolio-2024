<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os dados do formulário foram enviados via POST

    // Captura os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Configuração do SendGrid
    require 'vendor/autoload.php'; // Carrega o arquivo de autoload do SendGrid

    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom($email, $name);
    $email->setSubject("Assunto do Email");
    $email->addTo("eulucaspivotto@gmail.com", "Nome Destinatário");
    $email->addContent("text/plain", $message);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY')); // Obtém a chave de API do ambiente

    try {
        // Tenta enviar o email
        $response = $sendgrid->send($email);

        if ($response->statusCode() == 202) {
            echo 'SENDING'; // Email enviado com sucesso
        } else {
            echo 'ERROR'; // Problema no envio do email
        }
    } catch (Exception $e) {
        echo 'ERROR'; // Exceção capturada durante o envio do email
    }
} else {
    echo 'ERROR'; // Método de requisição inválido (esperava POST)
}
?>
