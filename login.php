<?php
session_start();
include 'db.php';

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM form WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "email"; 
    } else {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $email;
            echo "success";
        } else {
            echo "password";
        }
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
    <title>Login Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-color: #f7f9fc;
    }
    .container {
        max-width: 400px;
        margin-top: 50px;
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .form-control {
        border-radius: 5px;
        padding: 10px;
    }
    .register-btn {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        background-color: #4e73df;
        color: white;
        font-size: 16px;
    }
    .register-btn:hover {
        background-color: #2e59d9;
    }
    .login-link {
        text-align: center;
        margin-top: 15px;
    }
    .login-link a {
        color: #4e73df;
        font-weight: bold;
        text-decoration: none;
    }
    .login-link a:hover {
        text-decoration: underline;
    }
    .error {
        color: red;
        font-size: 0.875rem;
    }
</style>
<body>
<div class="container">
    <h2>Log in</h2>
    <form id="loginForm">
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="loginEmail" name="email" required placeholder="Enter your email">
            <span id="loginEmailError" class="error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginPassword" name="password" required placeholder="Enter your password">
            <span id="loginPasswordError" class="error"></span>
        </div>

        <a href="forgot_password.php">Forgot password?</a>
        
        <button type="submit" class="btn register-btn mt-3">Log in</button>
        <p class="login-link">You don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You have successfully logged in.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and jQuery Validate CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#loginForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: 'Invalid email format. Make sure it contains "@" and a valid domain.'
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 6 characters long."
                }
            },
            submitHandler: function(form) {
                let email = $('#loginEmail').val();
                let password = $('#loginPassword').val();

                $.ajax({
                    url: '',  
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.trim() === "success") {
                            $('#staticBackdropLabel').text('Login Successful!');
                            $('.modal-body').html('<p>You have successfully logged in.</p>');
                            $('#staticBackdrop').modal('show');

                            $('#staticBackdrop').on('hidden.bs.modal', function() {
                                window.location.href = 'index.php';  
                            });
                        } else if (response.trim() === "password") {
                            $('#loginPasswordError').text('Incorrect password. Please try again.');
                        } else if (response.trim() === "email") {
                            $('#loginEmailError').text('Email does not exist. Please register.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing your request.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
