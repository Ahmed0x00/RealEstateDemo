<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTransactionForm">
                    <div class="mb-3">
                        <label for="transactionType" class="form-label" id="labelTransactionType">Transaction Type</label>
                        <select id="transactionType" class="form-select" required>
                            <option id="chooseType" value="">Choose...</option>
                            <option id="incomeType" value="income">Income</option>
                            <option id="outcomeType" value="outcome">Expenses</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transactionAmount" class="form-label" id="labelTransactionAmount">Amount</label>
                        <input type="text" class="form-control" id="transactionAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="transactionFrom" class="form-label" id="labelTransactionFrom">From</label>
                        <input type="text" class="form-control" id="transactionFrom" name="from" required>
                    </div>
                    <div class="mb-3">
                        <label for="transactionTo" class="form-label" id="labelTransactionTo">To</label>
                        <input type="text" class="form-control" id="transactionTo" name="to" required>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTransactionButton">Save Transaction</button>
            </div>
        </div>
    </div>
</div>

<!-- Container for Alerts -->
<div id="alertContainer"></div>

<script>
// Function to add commas to the number input as the user types
function formatNumberInput(input) {
    let value = input.value.replace(/,/g, ''); // Remove any existing commas
    if (!isNaN(value) && value !== '') {
        value = parseFloat(value).toLocaleString('en'); // Format with commas
        input.value = value;
    }
}

document.getElementById('transactionAmount').addEventListener('input', function (e) {
    formatNumberInput(e.target);
});

// Optional: Remove commas before form submission if needed
document.getElementById('saveTransactionButton').addEventListener('click', function () {
    const amountField = document.getElementById('transactionAmount');
    amountField.value = amountField.value.replace(/,/g, ''); // Remove commas before saving
});
</script>
