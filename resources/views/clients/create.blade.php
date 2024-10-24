<!-- Add Client Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClientForm">
                    <div class="mb-3">
                        <label for="clientName" class="form-label" id="labelClientName">Name</label>
                        <input type="text" class="form-control" id="clientName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientEmail" class="form-label" id="labelClientEmail">Email</label>
                        <input type="email" class="form-control" id="clientEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientPhone" class="form-label" id="labelClientPhone">Phone</label>
                        <input type="text" class="form-control" id="clientPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientActions" class="form-label" id="labelClientActions">Actions</label>
                        <input type="text" class="form-control" id="clientActions" name="actions" required>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveClientButton">Save Client</button>
            </div>
        </div>
    </div>
</div>

<!-- Container for Alerts -->
<div id="alertContainer"></div>

<!-- Custom JS Files -->
<script src="js/ClientsController.js"></script>
<script src="js/script.js"></script>
