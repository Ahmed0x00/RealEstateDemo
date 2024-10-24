<!-- Custom Stylesheet -->
<style href="css/style.css"></style>

<!-- Container for Alerts -->
<div class="container">
    <div id="alertContainer" class="mt-3"></div>
</div>

<!-- Sidebar Navigation -->
<div id="Nav" class="sidebar">
    <div id="side" class="shadow-lg">
        <div class="accordion justify-content-evenly gap-2 d-flex flex-column" id="accordionExample">
            
            <!-- Home Item -->
            <div class="accordion-item" onclick="Route('home')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-house"></i>
                        <p id="nav1s" class="fs-5 fw-normal">Home</p>
                    </div>
                </h2>
            </div>
            
            <!-- Employees Item -->
            <div class="accordion-item" onclick="Route('employees')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-regular fs-5 fa-address-card"></i>
                        <p id="nav2s" class="fs-5 fw-normal">Employees</p>
                    </div>
                </h2>
            </div>
            
            
            <!-- Clients Item -->
            <div class="accordion-item" onclick="Route('clients')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-users"></i>
                        <p id="nav4s" class="fs-5 fw-normal">Clients</p>
                    </div>
                </h2>
            </div>
            
            <!-- Transactions Item -->
            <div class="accordion-item" onclick="Route('transactions')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-money-bill-transfer"></i>
                        <p id="nav5s" class="fs-5">Transactions</p>
                    </div>
                </h2>
            </div>
            
            
            <!-- Resources Item -->
            <div class="accordion-item" onclick="Route('resources')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-box"></i>
                        <p id="nav7s" class="fs-5">Resources</p>
                    </div>
                </h2>
            </div>
            
            <!-- Units Item -->
            <div class="accordion-item" onclick="Route('units')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-th"></i>
                        <p id="nav8s" class="fs-5 fw-normal">Units</p>
                    </div>
                </h2>
            </div>
            
            <!-- Balance Item -->
            <div class="accordion-item" onclick="Route('balance')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-solid fs-5 fa-vault"></i>
                        <p id="nav9s" class="fs-5 fw-normal">Balance</p>
                    </div>
                </h2>
            </div>

            <!-- Reports Item -->
            <div class="accordion-item" onclick="Route('reports')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-regular fs-5 fa-file"></i>
                        <p id="nav6s" class="fs-5">Reports</p>
                    </div>
                </h2>
            </div>

            <!-- Contractors Item -->
            <div class="accordion-item" onclick="Route('contractors')">
                <h2 class="accordion-header">
                    <div class="options d-flex justify-content-start p-3 align-items-center gap-2">
                        <i class="fa-regular fs-5 fa-id-badge"></i>
                        <p id="nav3s" class="fs-5 fw-normal">Contractors</p>
                    </div>
                </h2>
            </div>
            

        </div>
    </div>
</div>


<!-- Navbar -->
<div class="navb wow fadeInDown px-5 py-2 d-flex justify-content-between align-items-center shadow-sm bg-white"
    style="visibility: visible; animation-name: fadeInDown;">
    <img src="images/logo.png" alt="Logo" width="70px" onclick="Route('home')">
    <div class="d-flex gap-4 justify-content-center align-items-center">
        <!-- User Role -->
        <h5 id="role" class="px-4 rounded-5 py-2 m-0">{{ Auth::user()->role }}</h5>
        
        <!-- Language Dropdown -->
        <div class="dropdown">
            <div data-bs-toggle="dropdown" aria-expanded="false" class="flex iconic">
                <i class="fa-solid ihover fs-3 fa-globe" aria-hidden="true"></i>
                <div class="overflow-hidden">
                    <p id="lang" class="p-0 m-0 fs-5"></p>
                </div>
                <ul class="dropdown-menu">
                    <li onclick="setLanguage('ar')"><a id="lang1" class="dropdown-item text-center">العربية</a></li>
                    <li onclick="setLanguage('en')"><a id="lang2" class="dropdown-item text-center">English</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Settings Dropdown -->
        <div class="dropdown">
            <div data-bs-toggle="dropdown" aria-expanded="false" class="flex iconic">
                <i class="fa-solid ihover fs-3 fa-gear" aria-hidden="true"></i>
                <div class="overflow-hidden">
                    <p id="nav2" class="p-0 m-0 fs-5">Settings</p>
                </div>
                <ul class="dropdown-menu">
                    <li onclick="Route('profile')">
                        <a class="dropdown-item">
                            <i class="fa-regular fa-user px-2"></i>
                            <span id="profile">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="flex iconic">
            <i style="color: var(--bs-danger)" class="fa-solid ihover fs-3 fa-right-from-bracket" aria-hidden="true"></i>
            @csrf
            <div onclick="logout()" class="overflow-hidden">
                <p id="nav3" class="danger p-0 m-0 fs-5">Logout</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom Script -->
<script src="js/script.js"></script>
