<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href='css/style.css'>
    <title>RealEstate</title>
</head>

<body>

@include('home.navbar')
    <div class="content mt-1">
        <div class="stats">
            <div onclick="Route('transactions')" class="stat">
                <div class="d-flex gap-1 pb-2 align-items-center justify-content-start">
                    <div class="icon">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                    <div id="home1" class="label fs-4 fw-bold "></div>
                </div>
                <div id="totalTransactions" class="value"></div>
            </div>
            <div onclick="Route('transactions?type=income')" class="stat">
                <div class="d-flex gap-1 pb-2 align-items-center justify-content-start">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-trend-up text-success"></i>
                    </div>
                    <div id="home2" class="label fs-4 fw-bold "></div>
                </div>
                <div id="totalIncome" class="value money"></div>
            </div>
            <div onclick="Route('transactions?type=outcome')" class="stat">
                <div class="d-flex gap-1 pb-2 align-items-center justify-content-start">
                    <div class="icon">
                        <i class="fa-solid text-danger fa-arrow-trend-down"></i>
                    </div>
                    <div id="home3" class="label fs-4 fw-bold "></div>
                </div>
                <div id="totalExpenses" class="value money"></div>
            </div>
            <div class="stat" onclick="Route('balance')">
                <div class="d-flex gap-1 pb-2 align-items-center justify-content-start">
                    <div class="icon">
                        <i class="fa-solid text-success fs-3 fa-dollar"></i>
                    </div>
                    <div id="home4" class="label fs-4 fw-bold"></div>
                </div>
                <div id="balance" class="value money">
                    <span class="align-items-center" id="loader"><i
                            class="fa-solid fs-1 p-0 m-0 fa-circle-notch fa-spin"></i></span>
                </div>
            </div>
        </div>
        <div class="charts d-flex flex-wrap align-items-center">

            <!-- Profits Container for Last 15 Transactions -->
            <div class="chart1 flex-column rounded-3 gap-1 p-3 bg-white profits-container">
                <h2 id="home7">Profits</h2>
                <div id="lastTransactions" class="transactions-list">
                    <!-- Transactions will be dynamically added here -->
                </div>
            </div>
            <div class="chart2 flex-column rounded-3 gap-1 p-3 bg-white pie-chart">
                <h2 id="home6"></h2>
                <canvas style="margin-top: 25px;" id="pieChart"></canvas>
                <div class="legend d-flex justify-content-center align-items-center">
                    <div class="item">
                        <div class="color" style="background-color: #28a745;"></div>
                        <span id="home6_1">Income</span>
                    </div>
                    <div class="item">
                        <div class="color" style="background-color: red;"></div>
                        <span id="home6_2">Expenses</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="js/script.js"></script>
<script src="js/home.js"></script>

</html>