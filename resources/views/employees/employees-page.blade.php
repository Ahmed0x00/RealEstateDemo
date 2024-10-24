<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="employeeTitle">Employee List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href='css/style.css'>

    <style>
        .btn-toggle {
            color: #333;
            padding: 50px 110px;
            cursor: pointer;
            margin-left: 5px;
        }

        .btn-toggle:hover {
            background-color: #e0e0e0;
        }

        .add-btn {
            color: #fff;
            height: 38px;
        }

        .table-container {
            padding: 20px;
            margin-top: 20px;
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-bar {
            flex-grow: 1;
            max-width: 400px;
        }

        .search-bar .input-group-text {
            background-color: #007bff;
            color: white;
        }

        .table-responsive {
            max-width: 100%;
            margin-bottom: 20px;
            max-height: 570px;
            overflow-y: auto;
            table-layout: fixed;
        }

        .action-text {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .continue-btn {
            color: #007bff;
            cursor: pointer;
        }

        .action-btn {
            margin-right: 5px;
            padding: 0.375rem 0.75rem;
        }

        .action-btn:hover,
        .add-btn:hover {
            opacity: 0.8;
        }

        .table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 200px;
            white-space: normal;
        }

        .see-more, .see-less {
            padding: 0;
            margin: 0;
            color: grey;
            cursor: pointer;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .search-group {
                flex-direction: column;
            }

            .search-bar,
            .add-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    @include('home.navbar') <!-- Placeholder for Navbar -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-2 table-container bg-white shadow px-3">
                <!-- Search Bar and Add Employee Button Row -->
                <div class="search-group">
                    <!-- Search Bar with Icon -->
                    <div class="input-group search-bar">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInputEmployee" placeholder="Search For Employee name">
                    </div>
    
                    <!-- Add Employee Button -->
                    @if (Auth::user()->role == 'owner')
                        <a href="#" class="btn btn-primary add-btn" id="addEmployeeBtn">Add Employee</a>
                    @endif
                </div>
    
                @include('employees.create')
    
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="employeeTable">
                        <thead class="table-light">
                            <tr>
                                <th id="employeeID">ID</th>
                                <th id="employeeNameColumn">Name</th>
                                <th id="employeeEmailColumn">Email</th>
                                <th id="employeePhoneColumn">Phone</th>
                                <th id="employeeActionsColumn">Actions</th>
                                @if (Auth::user()->role == 'owner')
                                    <th id="updateDeleteColumn">Update/Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            <tr>
                                <td colspan="6" class="text-center no-records"><span>there are no recorded Employees</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Custom JS Files -->
    <script src="js/EmployeesController.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
