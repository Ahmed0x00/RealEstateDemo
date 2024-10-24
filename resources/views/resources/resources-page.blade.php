<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources List</title>

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
        }
        .action-btn {
            margin-right: 5px;
            padding: 0.375rem 0.75rem;
        }
        .action-btn:hover, .add-btn:hover {
            opacity: 0.8;
        }
        .table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 200px;
            white-space: normal;
        }
        @media (max-width: 768px) {
            .search-group {
                flex-direction: column;
            }
            .search-bar, .add-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    @include('home.navbar')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-2 table-container bg-white shadow px-3">
                <div class="search-group">
                    <div class="input-group search-bar">
                        <span class="input-group-text" id="searchIcon"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInputResource" placeholder="Search For Resource ID">
                    </div>
    
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#resourceModal" id="addResourceButton">Add Resource</button>
                </div>
    
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="resourceTable">
                        <thead class="table-light">
                            <tr>
                                <th id="resourceIDColumn">ID</th>
                                <th id="resourceQuantityColumn">Quantity</th>
                                <th id="resourcePriceColumn">Price</th>
                                <th id="actionsColumn">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="resourceTableBody">
                            <tr>
                                <td colspan="4" class="text-center no-records" id="noRecordsResourcesMessage"><span>There are no recorded Resources</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('resources.create-resource')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/ResourcesController.js"></script>
</body>
</html>
