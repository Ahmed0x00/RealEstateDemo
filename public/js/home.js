$(document).ready(function () {
    // Get the selected language from local storage (default to 'en' if not found)
    const language = localStorage.getItem("language") || "en";

    // Make a single AJAX request to fetch today's summary
    $.ajax({
        url: "/api/today-summary",
        method: "GET",
        success: function (data) {
            // Update the respective HTML elements with the fetched data
            $("#totalTransactions").text(data.todayTransactions);
            $("#totalIncome").text(data.todayIncome);
            $("#totalExpenses").text(data.todayExpenses);
            $("#balance").text(data.balance);

            // Render the pie chart after updating the data
            renderPieChart();

            // Render the last 15 transactions
            renderLastTransactions(data.lastTransactions, language); // Pass the language as a parameter
        },
        error: function () {
            // In case of an error, display 'N/A' in the fields
            $("#totalTransactions").text("N/A");
            $("#totalIncome").text("N/A");
            $("#totalExpenses").text("N/A");
            $("#balance").text("N/A");
        },
    });
});

function renderPieChart() {
    // Get the values from the HTML elements and parse them correctly
    let totalExpenses = parseFloat(
        document.getElementById("totalExpenses").innerText.replace(/,/g, "")
    );
    let totalIncome = parseFloat(
        document.getElementById("totalIncome").innerText.replace(/,/g, "")
    );

    // If both are NaN, set them to 0
    if (isNaN(totalIncome)) totalIncome = 0;
    if (isNaN(totalExpenses)) totalExpenses = 0;

    // If both income and expenses are 0, show 50% for both
    let incomePercentage = 0;
    let expensesPercentage = 0;

    if (totalIncome === 0 && totalExpenses === 0) {
        incomePercentage = 50; // Default to 50%
        expensesPercentage = 50; // Default to 50%
    } else {
        // Calculate total and percentages
        const total = totalExpenses + totalIncome;
        incomePercentage = (totalIncome / total) * 100;
        expensesPercentage = (totalExpenses / total) * 100;
    }

    // Prepare the chart data
    const ctx = document.getElementById("pieChart").getContext("2d");

    const data = {
        labels: ["Income", "Expenses"], // Adjust labels if needed based on language
        datasets: [
            {
                label: "Income vs Expenses",
                data: [incomePercentage, expensesPercentage], // Dynamic data
                backgroundColor: ["#28a745", "red"], // Green for Income, Red for Expenses
                hoverOffset: 4,
            },
        ],
    };

    // Chart configuration
    const config = {
        type: "pie",
        data: data,
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    color: "white",
                    formatter: (value) => value.toFixed(2) + "%", // Display percentage
                    font: {
                        size: 24,
                        weight: "bold",
                    },
                },
                legend: {
                    display: false, // Hide default legend
                },
            },
        },
        plugins: [ChartDataLabels], // Enable the datalabels plugin
    };

    // Render the chart
    new Chart(ctx, config);
}

// Function to format a number with commas as thousand separators
function formatNumberWithCommas(number) {
    return number.toLocaleString();
}

function renderLastTransactions(transactions, language) {
    const container = $("#lastTransactions");
    container.empty(); // Clear previous content

    transactions.forEach((transaction) => {
        let typeLabel, arrow, amountClass;

        // Check the language and adjust the labels and arrows accordingly
        if (language === "ar") {
            arrow =
                transaction.type === "income"
                    ? '<i class="fa-solid fa-arrow-left text-success me-2"></i>'
                    : '<i class="fa-solid fa-arrow-right text-danger me-2"></i>';
            typeLabel =
                transaction.type === "income"
                    ? '<span class="text-success me-3">دخل</span>'
                    : '<span class="text-danger me-3">مصروفات</span>';
        } else {
            arrow =
                transaction.type === "income"
                    ? '<i class="fa-solid fa-arrow-left text-success me-2"></i>'
                    : '<i class="fa-solid fa-arrow-right text-danger me-2"></i>';
            typeLabel =
                transaction.type === "income"
                    ? '<span class="text-success me-3">Income</span>'
                    : '<span class="text-danger me-3">Expense</span>';
        }

        amountClass =
            transaction.type === "income" ? "text-success" : "text-danger"; // Class for amount color

            const transactionHtml = `
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center">
            <span class="label" style="width: 110px;">${arrow} ${typeLabel}</span>
        </div>
        <div class="flex-grow-1 text-center">
            <span class="transaction-amount ${amountClass}">${formatNumberWithCommas(transaction.amount)}</span>
        </div>
        <span class="transaction-date">${transaction.transaction_date}</span>
    </div>
`;

        container.append(transactionHtml);
    });
}
