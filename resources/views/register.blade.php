<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Estate Earnings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f9;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .container {
            max-width: 450px;
            margin: 50px auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .card-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 20px;
            padding: 10px 15px;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #2980b9;
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

    <div class="container">
        <div class="language-toggle">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-globe"></i> Language
            </button>
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                <li><a class="dropdown-item" onclick="setLanguage('ar');">Arabic</a></li>
                <li><a class="dropdown-item" onclick="setLanguage('en');">English</a></li>
            </ul>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 id="register2">Create Account</h3>
            </div>
            <div class="card-body">
                <p id="register3" class="text-muted mb-4">Please fill in your details to register</p>
                <form>
                    @csrf
                    <div class="mb-3">
                        <label id="nameRegister" for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                    </div>
                    <div class="mb-3">
                        <label id="emailRegister" for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="demo@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label id="balanceRegister" for="balance" class="form-label">Balance</label>
                        <input name="balance" class="form-control" id="balance" placeholder="Enter balance" min="0" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label id="passwordRegister" for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            <i onclick="togglePasswordVisibility()" class="fa fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-3" style="color: gray" id="passwordToggle"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label id="confirmPasswordRegister" for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="position-relative">
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                            <i onclick="toggleConfirmPasswordVisibility()" class="fa fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-3" style="color: gray" id="confirmPasswordToggle"></i>
                        </div>
                    </div>
                    <button type="submit" id="RegisterButton" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

    <script>
        // Function to format the number with commas
        function formatNumberWithCommas(value) {
            const number = parseFloat(value.replace(/,/g, ''));
            return isNaN(number) ? '' : number.toLocaleString('en-US');
        }
    
        // Event listener for the balance input
        document.getElementById('balance').addEventListener('input', function (e) {
            // Remove all non-digit characters (except dot for decimals)
            const rawValue = e.target.value.replace(/[^0-9.]/g, '');
    
            // Format the cleaned number
            const formattedValue = formatNumberWithCommas(rawValue);
            
            // Update the input value with the formatted number
            e.target.value = formattedValue;
        });
    
        document.getElementById('RegisterButton').addEventListener('click', function (e) {
            e.preventDefault();
    
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const balance = document.getElementById('balance').value.replace(/,/g, ''); // Remove commas for processing
    
            // Check if passwords match
            if (password !== confirmPassword) {
                displayAlert("Passwords do not match!", "danger");
                return;
            }
    
            // Prepare the data to be sent
            const data = {
                name: name,
                email: email,
                password: password,
                password_confirmation: confirmPassword,
                balance: parseFloat(balance) || 0 // Convert balance to a float and default to 0 if empty
            };
    
            // Send the registration request to the correct API endpoint
            fetch('/register', {  // Or update to '/api/register' if you're using an API route
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Registration successful") {
                    displayAlert("Registration successful! Redirecting to login...", "success");
                    setTimeout(() => {
                        window.location.href = "/login"; // Redirect to login page
                    }, 2000);
                } else if (data.message) {
                    displayAlert(data.message, "danger"); // Display error message from backend
                } else {
                    displayAlert('An unknown error occurred.', "danger"); // Handle unexpected cases
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayAlert('An error occurred while registering.', "danger");
            });
        });
    </script>
    
</body>

</html>