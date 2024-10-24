<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href='css/style.css'>

    <style>
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
            max-width: 380px;
        }

        .add-btn {
            color: #fff;
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

        .table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 200px;
            white-space: normal;
        }
    </style>
</head>

<body>

    @include('home.navbar')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-2 table-container bg-white shadow px-3">
    
                <!-- Search Bar and Add Transaction Button Row -->
                <div class="search-group">
                    <div class="input-group search-bar">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInputTransactions" placeholder="Search based on Sender or Receiver">
                        <button class="btn btn-outline-secondary" id="sortAscBtn" title="Sort by smaller ID">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button class="btn btn-outline-secondary" id="sortDescBtn" title="Sort by larger ID">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </div>
                    
    
                    <div class="input-group date-filter" style="max-width: 250px;">
                        <span class="input-group-text">Date:</span>
                        <input type="date" class="form-control" id="dateFilter" style="width: 120px;">
                    </div>
    
                    <button type="button" class="btn btn-primary add-btn" id="addTransactionBtn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Transaction</button>
                </div>
    
                @include('transactions.create')
    
                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="transactionsTable">
                        <thead class="table-light">
                            <tr>
                                <th id="transactionID">ID</th>
                                <th id="transactionTypeColumn">Type</th>
                                <th id="transactionAmountColumn">Amount</th>
                                <th id="transactionFromColumn">Sender</th>
                                <th id="transactionToColumn">Receiver</th>
                                <th id="transactionDate">Date</th>
                                <th id="transactionActions">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            <tr>
                                <td colspan="7" class="text-center no-records"><span>There are no recorded transactions</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
    

        <!-- Bootstrap JS Bundle (includes Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Custom JS Files -->
        <script src="js/TransactionsController.js"></script>
        <script src="js/script.js"></script>

</body>

</html>
