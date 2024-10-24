<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <div class="mb-3">
                        <label for="employeeName" class="form-label" id="labelEmployeeName">Name</label>
                        <input type="text" class="form-control" id="employeeName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeEmail" class="form-label" id="labelEmployeeEmail">Email</label>
                        <input type="email" class="form-control" id="employeeEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeePhone" class="form-label" id="labelEmployeePhone">Phone</label>
                        <input type="text" class="form-control" id="employeePhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeActions" class="form-label" id="labelEmployeeActions">Actions</label>
                        <input type="text" class="form-control" id="employeeActions" name="actions" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeePassword" class="form-label" id="labelEmployeePassword">Password</label>
                        <input type="password" class="form-control" id="employeePassword" name="password" required>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEmployeeButton">Save Employee</button>
            </div>
        </div>
    </div>
</div>

<!-- Container for Alerts -->
<div id="alertContainer"></div>

    <!-- Custom JS Files -->
    <script src="js/EmployeesController.js"></script>
    <script src="js/script.js"></script>