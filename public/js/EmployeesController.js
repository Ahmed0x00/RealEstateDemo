$(document).ready(function () {
    // Initialize the table and search input
    fetchEmployees();

    // Event listener for search input
    $("#searchInputEmployee").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchEmployees(searchTerm);
    });

    // Event listener for Add Employee button
    $("#addEmployeeBtn").on("click", function () {
        resetEmployeeForm();
        $("#addEmployeeModalLabel").text("Add Employee");
        $("#saveEmployeeButton").text("Save Employee");
        $("#saveEmployeeButton").off("click").on("click", addEmployee);
        $("#addEmployeeModal").modal("show");
    });
});

function toggleActions(button, fullActions) {
    const parentTd = $(button).closest("td");
    const shortActionsElement = parentTd.find(".short-actions");
    const fullActionsElement = parentTd.find(".full-actions");
    const seeMoreButton = parentTd.find(".see-more");
    const seeLessButton = parentTd.find(".see-less");

    if (fullActionsElement.hasClass("d-none")) {
        // Show full actions
        fullActionsElement.removeClass("d-none");
        seeMoreButton.addClass("d-none"); // Hide see more button
        seeLessButton.removeClass("d-none"); // Show see less button
        // Update the short actions text to remove the ellipsis
        shortActionsElement.text(fullActions);
    } else {
        // Hide full actions
        fullActionsElement.addClass("d-none");
        seeMoreButton.removeClass("d-none"); // Show see more button
        seeLessButton.addClass("d-none"); // Hide see less button
        // Update the short actions text to show the truncated version with ellipsis
        shortActionsElement.text(
            fullActions.slice(0, 15) + (fullActions.length > 15 ? "..." : "")
        );
    }
}

// Function to fetch employees (filtered by search term)
function fetchEmployees(searchTerm = "") {
    // Get the selected language from local storage (default to 'en' if not found)
    const language = localStorage.getItem("language") || "en";

    // Define button labels based on the language
    const updateLabel = language === "ar" ? "تحديث" : "Update";
    const deleteLabel = language === "ar" ? "حذف" : "Delete";

    $.ajax({
        url: "api/employees",
        method: "GET",
        success: function (data) {
            const employees = data.filter((employee) =>
                employee.name.toLowerCase().includes(searchTerm.toLowerCase())
            );

            if (employees.length > 0) {
                $("#employeeTableBody").empty();

                employees.forEach((employee) => {
                    const employeeRow = `
                        <tr id="employeeRow_${employee.id}">
                            <td id="employeeId_${employee.employee_id}">${employee.employee_id}</td>
                            <td id="employeeName_${employee.id}">${employee.name}</td>
                            <td id="employeeEmail_${employee.id}">${employee.email}</td>
                            <td id="employeePhone_${employee.id}">${employee.phone ? employee.phone : "N/A"}</td>
                            <td id="employeeActions_${employee.id}">
                                <span class="short-actions" id="shortActions_${employee.id}">${employee.actions.slice(0, 15)}${
                        employee.actions.length > 15 ? "..." : ""
                    }</span>
                                ${
                                    employee.actions.length > 15
                                        ? `
                                <button class="btn btn-link see-more" id="seeMoreBtn" onclick="toggleActions(this, '${employee.actions}')">See more</button>
                                <span class="full-actions d-none" id="fullActions">${employee.actions}</span>
                                <button class="btn btn-link see-less d-none" id="seeLessBtn" onclick="toggleActions(this, '${employee.actions}')">See less</button>
                                `
                                        : ""
                                }
                            </td>
                            ${
                                $("#updateDeleteColumn").length
                                    ? `
                            <td id="employeeActionsColumn_${employee.id}">
                                <button class="btn btn-warning action-btn" id="editBtn" onclick="editEmployee(${employee.id})">${updateLabel}</button>
                                <button class="btn btn-danger action-btn" id="deleteBtn" onclick="deleteEmployee(${employee.id})">${deleteLabel}</button>
                            </td>
                            `
                                    : ""
                            }
                        </tr>
                    `;
                    $("#employeeTableBody").append(employeeRow);
                });
            } else {
                $("#employeeTableBody").html(
                    '<tr><td colspan="6" class="text-center no-records" id="noRecordsResourcesMessage">There are no recorded Employees</td></tr>'
                );
            }
        },
        error: function () {
            displayAlert("Failed to fetch employees.", "danger");
        },
    });
}

// Function to reset the form fields
function resetEmployeeForm() {
    $("#employeeName").val("");
    $("#employeeEmail").val("");
    $("#employeePhone").val("");
    $("#employeeActions").val("");
    $("#employeePassword").val("");
}

// Function to handle adding a new employee
function addEmployee() {
    const formData = {
        name: $("#employeeName").val(),
        email: $("#employeeEmail").val(),
        phone: $("#employeePhone").val(),
        role: "employee",
        actions: $("#employeeActions").val(),
        password: $("#employeePassword").val(),
    };

    $.ajax({
        url: "api/employees",
        method: "POST",
        data: formData,
        success: function (response) {
            $("#addEmployeeModal").modal("hide");
            displayAlert("Employee created successfully", "success");
            fetchEmployees(); // Refresh the list after adding a new employee
        },
        error: function (xhr) {
            const errorMessage =
                xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : "Failed to create employee";
            if (xhr.status === 409) {
                displayAlert(
                    "Email already exists. Please use a different email.",
                    "danger"
                );
            } else {
                displayAlert(errorMessage, "danger");
            }
        },
    });
}

// Function to edit an employee
function editEmployee(id) {
    // Fetch the existing employee data
    $.ajax({
        url: `api/employees/${id}`,
        method: "GET",
        success: function (response) {
            const employee = response;

            if (employee) {
                $("#employeeName").val(employee.name);
                $("#employeeEmail").val(employee.email);
                $("#employeePhone").val(employee.phone);
                $("#employeeActions").val(employee.actions);
                $("#employeePassword").val("");

                $("#addEmployeeModalLabel").text("Edit Employee");
                $("#saveEmployeeButton").text("Update Employee");

                $("#addEmployeeModal").modal("show");

                $("#saveEmployeeButton")
                    .off("click")
                    .on("click", function () {
                        updateEmployee(id);
                    });
            } else {
                displayAlert("No employee found for this ID.", "danger");
            }
        },
        error: function (xhr) {
            console.error("Error fetching employee details:", xhr);
            displayAlert("Failed to fetch employee details for editing.", "danger");
        },
    });
}

// Function to update an existing employee
function updateEmployee(id) {
    const formData = {
        name: $("#employeeName").val(),
        email: $("#employeeEmail").val(),
        phone: $("#employeePhone").val(),
        actions: $("#employeeActions").val(),
        password: $("#employeePassword").val(),
    };

    $.ajax({
        url: `api/employees/${id}`,
        method: "PUT",
        data: formData,
        success: function (response) {
            $("#addEmployeeModal").modal("hide");
            displayAlert("Employee updated successfully", "success");
            fetchEmployees();
        },
        error: function (xhr) {
            const errorMessage =
                xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : "Failed to update employee";
            displayAlert(errorMessage, "danger");
        },
    });
}

// Function to delete an employee
function deleteEmployee(id) {
    if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
            url: `api/employees/${id}`,
            method: "DELETE",
            success: function () {
                displayAlert("Employee deleted successfully", "success");
                fetchEmployees(); // Refresh the list after deletion
            },
            error: function () {
                displayAlert("Failed to delete employee.", "danger");
            },
        });
    }
}
