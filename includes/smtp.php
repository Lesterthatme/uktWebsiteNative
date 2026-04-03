   <?php


   $mail->isSMTP(); // Send using SMTP
   $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
   $mail->SMTPAuth = true; // Enable SMTP authentication
   $mail->Username = 'samonrotana29@gmail.com'; // SMTP username
   $mail->Password = 'lsfy dzid fzzz ghpl'; // SMTP password
   $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
   $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above