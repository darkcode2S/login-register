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

    if ($result->num_rows > 0) {
        echo "Email already exists.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO form (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Registration Form</title>
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
        <h2>Register</h2>
        <form id="registrationForm">
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                <span id="emailError" class="error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                <span id="passwordError" class="error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="con-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" required placeholder="Enter your password">
                <span id="con-passwordError" class="error"></span>
            </div>
            <button type="submit" class="btn register-btn">Register</button>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Register</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Registration successful!
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
            $('#registrationForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true 
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        pwcheck: true 
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password" 
                    }
                },
                messages: {
                    email: {
                        required: "Email is required.",
                        email: 'Invalid email format. Make sure it contains "@" and a valid domain.'
                    },
                    password: {
                        required: "Password is required.",
                        minlength: "Password must be at least 6 characters long.",
                        pwcheck: 'Password must include at least one uppercase letter, one lowercase letter, and one number.'
                    },
                    cpassword: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match. Please confirm your password." 
                    }
                },
                submitHandler: function(form) {
                    let email = $('#email').val();
                    let password = $('#password').val();

                    $.ajax({
                        url: '',  
                        type: 'POST',
                        data: {
                            email: email,
                            password: password
                        },
                        success: function(response) {
                            if (response === 'Registration successful!') {
                                $('#staticBackdrop').modal('show');
                            }
                            $('#staticBackdrop').on('hidden.bs.modal', function() {
                                window.location.href = 'login.php';  
                            });

                            $('#registrationForm')[0].reset();
                        },
                        error: function() {
                            alert('An error occurred while processing your request.');
                        }
                    });
                }
            });

            $.validator.addMethod("pwcheck", function(value) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/.test(value);
            });
        });
    </script>
</body>
</html>
</script>
</body>
</html>
