<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Error inesperado. Intenta más tarde.'
];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método no permitido");
    }

    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $correo = trim(filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL));
    $ruc = trim(filter_input(INPUT_POST, 'ruc', FILTER_SANITIZE_STRING));
    $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING));
    $ciudad = trim(filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));

    if (!$nombre || !$correo || !$telefono || !$descripcion) {
        throw new Exception('Campos obligatorios faltantes.');
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Correo inválido.');
    }

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'mail.tiflobraperu.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ventas@tiflobraperu.com';
    $mail->Password = 'tiflobraperu123';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('ventas@tiflobraperu.com', 'Tiflobraille');
    $mail->addAddress('ventas@tiflobraperu.com');
    $mail->addReplyTo($correo, $nombre);

    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje de contacto - Tiflobraille';
    $mail->Body = "
        <h2>Nuevo mensaje de contacto</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Correo:</strong> $correo</p>
        <p><strong>RUC:</strong> $ruc</p>
        <p><strong>Teléfono:</strong> $telefono</p>
        <p><strong>Ciudad:</strong> $ciudad</p>
        <p><strong>Descripción:</strong> $descripcion</p>
    ";
    $mail->AltBody = "Nuevo mensaje de contacto\nNombre: $nombre\nCorreo: $correo\nRUC: $ruc\nTeléfono: $telefono\nCiudad: $ciudad\nDescripción: $descripcion";

    if (!$mail->send()) {
        throw new Exception('No se pudo enviar el mensaje.');
    }

    $response = [
        'status' => 'success',
        'message' => '¡Gracias! Tu mensaje ha sido enviado correctamente.'
    ];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
