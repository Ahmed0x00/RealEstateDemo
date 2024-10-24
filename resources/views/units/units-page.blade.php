<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Units List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href='css/style.css'>

    <style>
        /* Custom styling */
        .add-btn {
            color: #fff;
            height: 38px; /* Match the height with the search bar */
        }
        .table-container {
            padding: 20px;
            margin-top: 20px;
        }

        /* Styling for the search bar and button */
        .search-group {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between the search bar and button */
            margin-bottom: 20px;
        }

        .search-bar {
            flex-grow: 1;
            max-width: 400px; /* Limit the size of the search bar */
        }

        .search-bar .input-group-text {
            background-color: #007bff; /* Blue background for icon */
            color: white;
        }

        /* Scrollable table */
        .table-responsive {
            max-width: 100%; /* Makes the table take full width */
            margin-bottom: 20px;
            max-height: 570px; /* Set a max height for the table */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        /* Truncate actions */
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

        /* Update and Delete Buttons */
        .action-btn {
            margin-right: 5px;
            padding: 0.375rem 0.75rem;
        }

        /* Hover effect for all buttons */
        .action-btn:hover, .add-btn:hover {
            opacity: 0.8;
        }

        .table td {
            word-wrap: break-word; /* Allows breaking long words onto the next line */
            overflow-wrap: break-word; /* Similar to word-wrap, but more widely supported */
            max-width: 200px; /* Set a maximum width for the cells */
            white-space: normal; /* Allow normal wrapping of text */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .search-group {
                flex-direction: column;
            }

            .search-bar, .add-btn {
                width: 100%; /* Full width on small screens */
            }
        }
    </style>
</head>
<body>

    @include('home.navbar') <!-- Placeholder for Navbar -->

    <!-- Main Container -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-2 table-container bg-white shadow px-3">
            <!-- Search Bar and Add Unit Button Row -->
            <div class="search-group">
                <!-- Search Bar with Icon -->
                <div class="input-group search-bar">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInputUnitPlaceholder" placeholder="Search For Unit Code">
                </div>

                <!-- Add Unit Button -->
                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#unitModal" id="btnAddUnit">Add Unit</button>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="unitTable">
                    <thead class="table-light">
                        <tr>
                            <th id="UnitCodeColumn">Code</th>
                            <th id="UnitAreaColumn">Area (sq ft)</th>
                            <th id="UnitPriceColumn">Price</th>
                            <th id="ActionsColumn">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="unitTableBody">
                        <tr>
                            <td colspan="4" class="text-center no-records"><span>There are no recorded Units</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    @include('units.create-unit')

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Custom JS Files -->
    <script src="js/UnitsController.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
