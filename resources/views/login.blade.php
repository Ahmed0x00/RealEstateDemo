<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estate Earnings - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 400px;
            max-width: 100%;
        }

        .login-header {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .btn-login {
            background-color: #3498db;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #2980b9;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-footer a {
            color: #3498db;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .language-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
    <div id="alertContainer" class="mt-3"></div>
    <div class="language-toggle">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-globe"></i> Language
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" onclick="setLanguage('ar');">Arabic</a></li>
            <li><a class="dropdown-item" onclick="setLanguage('en');">English</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2 id="sub">Login</h2>
            </div>
            <div class="login-form">
                <form id="loginForm">
                    <div class="form-group">
                        <label id="emailLogin" for="email">Email</label>
                        <input id="email" type="email"  name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label id="passwordLogin" for="password">Password</label>
                        <div class="position-relative">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <i onclick=" togglePasswordVisibility()"
                                class="fas fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-3"
                                style="color: gray" id="passwordToggle"></i>
                        </div>
                    </div>
                    <button type="submit" id="LoginButton" class="btn-login">Login</button>
                </form>
                <div class="login-footer">
                    <p id="dontHaveAccountBtn">Don't have an account? <a href="register">Register now</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script>
        document.getElementById('LoginButton').addEventListener('click', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Prepare the data to be sent
            const data = {
                email: email,
                password: password
            };

            // Send the login request
            fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === "Login successful") {
                        displayAlert("Login successful! Redirecting to dashboard...", "success");
                        setTimeout(() => {
                            window.location.href = "home"; // Redirect to dashboard page
                        }, 800);
                    } else if (data.message) {
                        displayAlert(data.message, "danger"); // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayAlert('An error occurred while logging in.', "danger");
                });
        });
    </script>
</body>

</html>
