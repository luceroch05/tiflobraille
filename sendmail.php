<?php
// Incluir archivos de PHPMailer (Asegúrate de que la ruta sea correcta)
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $ruc = $_POST['ruc'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.tiflobraperu.com';  // Cambia esto con el servidor SMTP de tu hosting
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ventas@tiflobraperu.com';  // Cambia esto por tu correo
        $mail->Password   = 'tiflobraperu123';  // Cambia esto por tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;  

        // Remitente y destinatario
        $mail->setFrom('ventas@tiflobraperu.com', 'Tu Empresa');
        $mail->addAddress('ventas@tiflobraperu.com', '');  // Cambia esto por el correo receptor

        // Configurar el correo en HTML
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "
            <h2>Nuevo mensaje de contacto</h2>
            <p><b>Nombre:</b> $nombre</p>
            <p><b>Correo:</b> $correo</p>
            <p><b>RUC:</b> $ruc</p>
            <p><b>Teléfono:</b> $telefono</p>
            <p><b>Ciudad:</b> $ciudad</p>
            <p><b>Descripción:</b> $descripcion</p>
        ";

        // Enviar el correo
        $mail->send();
        echo "¡Mensaje enviado correctamente!";
    } catch (Exception $e) {
        echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
} else {
    echo "Método de envío no válido.";
}
?>
