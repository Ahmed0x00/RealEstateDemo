$(document).ready(function () {
    const apiBaseUrl = 'api/transactions';
    let sortOrder = 'desc'; // Default sort order

    // Function to fetch and display transactions
    function fetchTransactions() {
        $.ajax({
            url: apiBaseUrl,
            method: 'GET',
            success: function (data) {
                const transactionsTableBody = $('#transactionsTableBody');
                transactionsTableBody.empty(); // Clear previous entries
    
                const searchValue = $('#searchInputTransactions').val().toLowerCase();
                const selectedDate = $('#dateFilter').val();
                const language = localStorage.getItem("language") || "en";
                const transactions = data.transactions;
    
                // Retrieve type parameter from URL
                const urlParams = new URLSearchParams(window.location.search);
                const transactionTypeFilter = urlParams.get('type'); // income or outcome
    
                // Sort transactions based on the selected order
                transactions.sort((a, b) => sortOrder === 'desc' ? b.id - a.id : a.id - b.id);
    
                // Define labels based on language
                const incomeLabel = language === 'ar' ? 'دخل' : 'Income';
                const outcomeLabel = language === 'ar' ? 'مصروفات' : 'Expenses';
                const invoiceLabel = language === 'ar' ? 'طباعة' : 'Invoice';
                const deleteLabel = language === 'ar' ? 'حذف' : 'Delete';
    
                transactions.forEach(transaction => {
                    const id = transaction.id;
                    const amount = parseFloat(transaction.amount).toFixed(2);
                    const from = transaction.from.toLowerCase();
                    const to = transaction.to.toLowerCase();
                    const date = new Date(transaction.transaction_date).toLocaleDateString(); // Format date
    
                    const isIncome = transaction.type === 'income';
                    const type = isIncome ? incomeLabel : outcomeLabel;
                    const amountClass = isIncome ? 'text-success' : 'text-danger';
                    const rowClass = isIncome ? 'table-success' : 'table-danger';
                    const icon = isIncome ? '<i class="fas fa-arrow-right text-success"></i>' : '<i class="fas fa-arrow-left text-danger"></i>';
    
                    const transactionDate = new Date(transaction.transaction_date).toLocaleDateString();
                    const matchesSearch = from.includes(searchValue) || to.includes(searchValue);
                    const matchesDate = selectedDate ? transactionDate === new Date(selectedDate).toLocaleDateString() : true;
    
                    // Filter by type if type is specified in the URL
                    const matchesType = transactionTypeFilter ? transaction.type === transactionTypeFilter : true;
    
                    if (matchesSearch && matchesDate && matchesType) {
                        transactionsTableBody.append(`
                            <tr class="${rowClass}">
                                <td>${id}</td>
                                <td>${type}</td>
                                <td class="${amountClass}">${icon} ${parseFloat(amount).toLocaleString()}</td>
                                <td>${from}</td>
                                <td>${to}</td>
                                <td>${date}</td>
                                <td>
                                    <button class="btn btn-success action-btn" id="transactionInvoice_${id}" onclick="generateInvoice(${id})">
                                         ${invoiceLabel}
                                    </button>
                                    <button class="btn btn-danger action-btn" id="transactionDelete_${id}" onclick="deleteTransaction(${id})">
                                         ${deleteLabel}
                                    </button>
                                </td>
                            </tr>
                        `);
                    }
                });
    
                if (transactionsTableBody.is(':empty')) {
                    transactionsTableBody.append('<tr><td colspan="7" class="text-center no-records"><span>No records match the filter criteria</span></td></tr>');
                }
            },
            error: function (error) {
                console.error('Error fetching transactions:', error);
            }
        });
    }
    

    // Event listeners for sorting buttons
    $('#sortAscBtn').click(function () {
        sortOrder = 'asc';
        fetchTransactions();
    });

    $('#sortDescBtn').click(function () {
        sortOrder = 'desc';
        fetchTransactions();
    });

    // Event listeners for filters
    $('#searchInputTransactions, #dateFilter').on('input change', function () {
        fetchTransactions();
    });

    // Function to add a transaction
    $('#saveTransactionButton').click(function () {
        const transactionData = {
            type: $('#transactionType').val(),
            amount: $('#transactionAmount').val(),
            from: $('#transactionFrom').val(),
            to: $('#transactionTo').val(),
            transaction_date: new Date().toISOString().split('T')[0], // Get today's date in YYYY-MM-DD format
        };

        $.ajax({
            url: apiBaseUrl + (transactionData.type === 'income' ? '/income' : '/outcome'),
            method: 'POST',
            data: transactionData,
            success: function (response) {
                $('#addTransactionModal').modal('hide'); // Hide the modal
                fetchTransactions(); // Refresh the transactions list immediately
                displayAlert('Transaction added successfully!', 'success');
            },
            error: function (error) {
                console.error('Error adding transaction:', error);
                displayAlert('Failed to add transaction. Please try again.', 'danger');
            }
        });
    });

    // Function to delete a transaction
    window.deleteTransaction = function (id) {
        if (confirm('Are you sure you want to delete this transaction?')) {
            $.ajax({
                url: apiBaseUrl + '/' + id,
                method: 'DELETE',
                success: function (response) {
                    fetchTransactions(); // Refresh the transactions list immediately
                    displayAlert('Transaction deleted successfully!', 'success');
                },
                error: function (error) {
                    console.error('Error deleting transaction:', error);
                    displayAlert('Failed to delete transaction. Please try again.', 'danger');
                }
            });
        }
    };

    // Function to display Bootstrap alerts
    function displayAlert(message, type) {
        const sqlErrorKeywords = ['SQLSTATE', 'Integrity constraint violation', 'General error', 'Cannot be null', 'Duplicate entry'];
        const isSqlError = sqlErrorKeywords.some(keyword => message.includes(keyword));

        if (isSqlError) {
            console.warn("SQL Error suppressed:", message); // Optionally log it for debugging
            return;
        }

        const alertContainer = document.getElementById("alertContainer");
        const alertElement = document.createElement("div");
        alertElement.className = `alert alert-${type} alert-dismissible fade show`;
        alertElement.role = "alert";

        alertElement.style.cssText = `
        margin-left: 3rem; /* Margin left */
        `;
        alertElement.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        alertContainer.appendChild(alertElement);

        // Remove the alert after 0.5 seconds
        setTimeout(() => {
            alertElement.classList.remove("show");
            alertElement.addEventListener("transitionend", () => alertElement.remove());
        }, 1000);
    }

    // Initial fetch of transactions
    fetchTransactions();
});
