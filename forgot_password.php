<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM form WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));


        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        $sql = "UPDATE form SET reset_token = ?, reset_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();

        // Send reset link via email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'anthonycrausus14.ncmc@gmail.com';
            $mail->Password = 'xspyxnblidsfyenw'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

     
            $mail->setFrom('anthonycrausus14.ncmc@gmail.com', 'NCMC Rata Bay!');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click on this link to reset your password: 
                            <a href='http://localhost/validition_form_jazz/reset_password.php?token=$token'>Reset Password</a>";

            $mail->send();
            echo 'A password reset link has been sent to your email.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="forgot_password.php">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
