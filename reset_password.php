<?php
include 'db.php';

if (isset($_GET['token']) && isset($_POST['password'])) {
    $token = $_GET['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 


    $sql = "SELECT * FROM form WHERE reset_token = ? AND reset_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $sql = "UPDATE form SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $password, $token);
        $stmt->execute();

        echo "Password has been updated. You can now log in.";
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="reset_password.php?token=<?= htmlspecialchars($_GET['token']); ?>">
        <label for="password">Enter new password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
