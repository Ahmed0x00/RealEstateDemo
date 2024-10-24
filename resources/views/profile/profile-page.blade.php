<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Profile</title>
</head>
<body>

@include('home.navbar')

<div id="alertContainer"></div>

<div class="content mt-3">
    <div class="row gap-3">  
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-primary" id="userNameHeader"><i class="fas fa-user"></i> Name</h5>
                    <p class="card-text text-primary" id="userName"></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-primary" id="userEmailHeader"><i class="fas fa-envelope"></i> Email</h5>
                    <p class="card-text text-primary" id="userEmail"></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-primary" id="userRoleHeader"><i class="fas fa-user-tag"></i> Role</h5>
                    <p class="card-text text-primary" id="userRole"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional Cards Container -->
    <div class="row gap-3" id="optionalCards"></div>

    <!-- Change Password Button -->
    <button id="changePassword" type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
        Change Password
    </button>
</div>

@include('profile.change-password')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>
<script src="js/profile.js"></script>
</body>
</html>
