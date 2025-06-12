<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Cargar variables de entorno
require_once 'config.php';

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Error inesperado. Intenta más tarde.'
];

try {
    // Verificar método HTTP
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método no permitido");
    }

 

    // Sanitizar y validar datos de entrada
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $correo = trim(filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL));
    $ruc = trim(filter_input(INPUT_POST, 'ruc', FILTER_SANITIZE_STRING));
    $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING));
    $ciudad = trim(filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));

    // Validar campos obligatorios
    if (!$nombre || !$correo || !$telefono || !$descripcion) {
        throw new Exception('Todos los campos obligatorios deben completarse.');
    }

    // Validar formato de email
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato del correo electrónico no es válido.');
    }

    // Validar longitud de campos
    if (strlen($nombre) > 100 || strlen($descripcion) > 1000) {
        throw new Exception('Los datos exceden la longitud permitida.');
    }

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = SMTP_PORT;
    $mail->CharSet = 'UTF-8';

    // Configurar remitente y destinatario
    $mail->setFrom(SMTP_USERNAME, 'Formulario Tiflobraille');
    $mail->addAddress(RECIPIENT_EMAIL);
    $mail->addReplyTo($correo, $nombre);

    // Configurar contenido del email
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje de contacto - Tiflobraille';
    
    $mail->Body = "
    <html>
    <body style='font-family: Arial, sans-serif;'>
        <h2 style='color: #2c3e50;'>Nuevo mensaje de contacto</h2>
        <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
            <p><strong>Nombre:</strong> " . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Correo:</strong> " . htmlspecialchars($correo, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>RUC:</strong> " . htmlspecialchars($ruc, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Teléfono:</strong> " . htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Ciudad:</strong> " . htmlspecialchars($ciudad, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Descripción:</strong><br>" . nl2br(htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8')) . "</p>
        </div>
        <p style='font-size: 12px; color: #666;'>Mensaje enviado desde el formulario de contacto de Tiflobraille</p>
    </body>
    </html>";

    $mail->AltBody = "Nuevo mensaje de contacto\n\n" .
                     "Nombre: $nombre\n" .
                     "Correo: $correo\n" .
                     "RUC: $ruc\n" .
                     "Teléfono: $telefono\n" .
                     "Ciudad: $ciudad\n" .
                     "Descripción: $descripcion\n\n" .
                     "Mensaje enviado desde el formulario de contacto de Tiflobraille";

    // Enviar email
    if (!$mail->send()) {
        throw new Exception('No se pudo enviar el mensaje. Intenta nuevamente.');
    }

    $response = [
        'status' => 'success',
        'message' => '¡Gracias! Tu mensaje ha sido enviado correctamente. Te contactaremos pronto.'
    ];

} catch (Exception $e) {
    error_log("Error en sendmail.php: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>