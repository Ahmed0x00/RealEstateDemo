$(document).ready(function() {
    // Initialize the table and search input
    fetchClients();

    // Event listener for search input
    $('#searchInputClient').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        fetchClients(searchTerm);
    });

    // Event listener for Add Client button
    $('#addClient').on('click', function() {
        resetClientForm();
        $('#addClientModalLabel').text('Add Client');
        $('#saveClientButton').text('Save Client');
        $('#saveClientButton').off('click').on('click', addClient);
        $('#addClientModal').modal('show');
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

function fetchClients(searchTerm = '') {
    // Get the selected language from local storage (default to 'en' if not found)
    const language = localStorage.getItem("language") || "en";

    // Define button labels based on the language
    const updateLabel = language === "ar" ? "تحديث" : "Update";
    const deleteLabel = language === "ar" ? "حذف" : "Delete";

    $.ajax({
        url: 'api/clients',
        method: 'GET',
        success: function(data) {
            // No filtering by role, directly use the response
            const clients = data; // Assuming data is an array of clients

            if (clients.length > 0) {
                $('#clientTableBody').empty();

                clients.forEach(client => {
                    // Check if the client's name matches the search term
                    if (client.name.toLowerCase().includes(searchTerm)) {
                        const truncatedAction = client.actions.length > 15 ? `${client.actions.slice(0, 15)}...` : client.actions;

                        const clientRow = `
                            <tr>
                                <td>${client.client_id}</td>
                                <td>${client.name}</td>
                                <td>${client.email}</td>
                                <td>${client.phone ? client.phone : "N/A"}</td>
                                <td>
                                    <span class="short-actions">${client.actions.slice(0, 15)}${
                                        client.actions.length > 15 ? "..." : ""
                                    }</span>
                                    ${
                                        client.actions.length > 15
                                            ? `
                                    <button class="btn btn-link see-more" onclick="toggleActions(this, '${client.actions}')">See more</button>
                                    <span class="full-actions d-none">${client.actions}</span>
                                    <button class="btn btn-link see-less d-none" onclick="toggleActions(this, '${client.actions}')">See less</button>
                                    `
                                            : ""
                                    }
                                </td>
                                ${
                                    $("#updateDeleteColumnClient").length
                                        ? `
                                <td>
                                    <button class="btn btn-warning action-btn" onclick="editClient(${client.id})">${updateLabel}</button>
                                    <button class="btn btn-danger action-btn" onclick="deleteClient(${client.id})">${deleteLabel}</button>
                                </td>
                                `
                                        : ""
                                }
                            </tr>
                        `;
                        $('#clientTableBody').append(clientRow);
                    }
                });
            } else {
                $('#clientTableBody').html('<tr><td colspan="6" class="text-center no-records">There are no recorded Clients</td></tr>');
            }
        },
        error: function() {
            displayAlert('Failed to fetch clients.', 'danger');
        }
    });
}


// Function to reset the form fields
function resetClientForm() {
    $('#clientName').val('');
    $('#clientEmail').val('');
    $('#clientPhone').val('');
    $('#clientActions').val('');
    $('#clientPassword').val('');
}

// Function to handle adding a new client
function addClient() {
    const formData = {
        name: $('#clientName').val(),
        email: $('#clientEmail').val(),
        phone: $('#clientPhone').val(),
        role: 'client', // Assuming clients are treated as 'client'
        actions: $('#clientActions').val(),
        password: $('#clientPassword').val(),
    };

    $.ajax({
        url: 'api/clients', // Updated endpoint for adding clients
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#addClientModal').modal('hide');
            displayAlert('Client created successfully', 'success');
            fetchClients(); // Refresh the list after adding a new client
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                ? xhr.responseJSON.message 
                : 'Failed to create client';
            if (xhr.status === 409) { // Assuming 409 is returned for duplicate entry
                displayAlert('Email already exists. Please use a different email.', 'danger');
            } else {
                displayAlert(errorMessage, 'danger');
            }
        }
    });
}

// Function to edit a client
function editClient(id) {
    // Fetch the existing client data
    $.ajax({
        url: `api/clients/${id}`, // Updated endpoint for fetching client details
        method: 'GET',
        success: function(response) {
            // Access the user object from the response
            const client = response; // Assuming response is the client object

            if (client) {
                // Populate the form with the existing client data
                $('#clientName').val(client.name);
                $('#clientEmail').val(client.email);
                $('#clientPhone').val(client.phone);
                $('#clientActions').val(client.actions);
                $('#clientPassword').val(''); // Leave the password field empty

                // Update the modal title and button text for clarity
                $('#addClientModalLabel').text('Edit Client');
                $('#saveClientButton').text('Update Client');

                // Show the modal for editing
                $('#addClientModal').modal('show');

                // Update the save button behavior for updating a client
                $('#saveClientButton').off('click').on('click', function() {
                    updateClient(id); // Call update function with client ID
                });
            } else {
                displayAlert('No client found for this ID.', 'danger');
            }
        },
        error: function(xhr) {
            console.error('Error fetching client details:', xhr); // Log the error
            displayAlert('Failed to fetch client details for editing.', 'danger');
        }
    });
}

// Function to update an existing client
function updateClient(id) {
    const formData = {
        name: $('#clientName').val(),
        email: $('#clientEmail').val(),
        phone: $('#clientPhone').val(),
        actions: $('#clientActions').val(),
        password: $('#clientPassword').val(), // Include password if necessary
    };

    $.ajax({
        url: `api/clients/${id}`, // Updated endpoint for updating client
        method: 'PUT',
        data: formData,
        success: function(response) {
            $('#addClientModal').modal('hide');
            displayAlert('Client updated successfully', 'success');
            fetchClients();
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to update client';
            displayAlert(errorMessage, 'danger');
        }
    });
}

// Function to delete a client
function deleteClient(id) {
    if (confirm('Are you sure you want to delete this client?')) {
        $.ajax({
            url: `api/clients/${id}`, // Updated endpoint for deleting client
            method: 'DELETE',
            success: function() {
                displayAlert('client deleted successfully', 'success');
                fetchClients(); // Refresh the list after deletion
            },
            error: function() {
                displayAlert('Failed to delete client.', 'danger');
            }
        });
    }
}
