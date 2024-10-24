// Get language from localStorage, default to 'en' if not set
const language = localStorage.getItem('language') || 'en';

// Set text based on language
const updateText = language === 'ar' ? 'تحديث' : 'Update';
const deleteText = language === 'ar' ? 'حذف' : 'Delete';

$(document).ready(function() {
    fetchUnits(); // Fetches units when the page loads

    // Search input listener
    $('#searchInputUnitPlaceholder').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        fetchUnits(searchTerm);
    });

    // Add Unit button click event
    $('#addUnit').on('click', function() {
        resetUnitForm(); // Resets the form fields
        $('#unitModalLabel').text('Add Unit');
        $('#saveUnitButton').text('Save Unit');
        $('#unitModal').modal('show'); // Shows the modal
    });

    // Form submission handler for adding/updating a unit
    $('#unitForm').on('submit', function(event) {
        event.preventDefault(); // Prevents default form submission
        const unitId = $('#unitId').val(); // Get unitId from hidden input

        // Remove commas from area and price before submitting
        $('#unitArea').val($('#unitArea').val().replace(/,/g, ''));
        $('#unitPrice').val($('#unitPrice').val().replace(/,/g, ''));

        if (unitId) { // If unitId exists, it means we are editing
            updateUnit(unitId); 
        } else { // If unitId does not exist, it means we are adding a new unit
            addUnit(); 
        }
    });

    // Format area and price with commas while typing
    $('#unitArea, #unitPrice').on('input', function() {
        const value = $(this).val().replace(/,/g, ''); // Remove existing commas
        const formattedValue = parseFloat(value).toLocaleString('en-US', { maximumFractionDigits: 0 });
        $(this).val(formattedValue);
    });

    // Reset form fields and modal when the modal is closed
    $('#unitModal').on('hidden.bs.modal', function () {
        resetUnitForm(); // Clear the form fields
    });
});

// Function to reset the form fields
function resetUnitForm() {
    $('#unitId').val(''); // Ensure hidden ID is reset for adding
    $('#unitCode').val(''); // Clear code input
    $('#unitArea').val(''); // Clear area input
    $('#unitPrice').val(''); // Clear price input
    $('#unitModalLabel').text('Add Unit'); // Reset modal title
    $('#saveUnitButton').text('Save Unit'); // Reset save button text
}

// Function to fetch units (filtered by search term)
function fetchUnits(searchTerm = '') {
    $.ajax({
        url: 'api/units', // Assuming API endpoint for fetching units
        method: 'GET',
        success: function(data) {
            const units = data.units;

            $('#unitTableBody').empty(); // Clear table before appending new data

            if (units.length > 0) {
                let hasRecords = false; // To check if we have matching records
                units.forEach(unit => {
                    // Check if the unit's code matches the search term
                    if (unit.code.toLowerCase().includes(searchTerm)) {
                        hasRecords = true; // Found a matching record
                        const unitRow = `
                            <tr>
                                <td>${unit.code}</td>
                                <td>${parseFloat(unit.area).toLocaleString('en-US', { maximumFractionDigits: 0 })}</td>
                                <td>${parseFloat(unit.price).toLocaleString('en-US', { maximumFractionDigits: 0 })}</td>
                                <td>
                                    <button class="btn btn-warning action-btn" onclick="editUnit(${unit.id})">${updateText}</button>
                                    <button class="btn btn-danger action-btn" onclick="deleteUnit(${unit.id})">${deleteText}</button>
                                </td>
                            </tr>
                        `;
                        $('#unitTableBody').append(unitRow);
                    }
                });

                // If no records match the search term, show the no records message
                if (!hasRecords) {
                    $('#unitTableBody').html('<tr><td colspan="4" class="text-center no-records">There are no recorded Units</td></tr>');
                }
            } else {
                $('#unitTableBody').html('<tr><td colspan="4" class="text-center no-records">There are no recorded Units</td></tr>');
            }
        },
        error: function() {
            displayAlert('Failed to fetch units.', 'danger');
        }
    });
}

// The remaining functions (addUnit, editUnit, updateUnit, deleteUnit, displayAlert) remain unchanged...



// Function to handle adding a new unit
function addUnit() {
    const formData = {
        code: $('#unitCode').val(),
        area: $('#unitArea').val().replace(/,/g, ''), // Remove commas before sending
        price: $('#unitPrice').val().replace(/,/g, ''), // Remove commas before sending
    };

    $.ajax({
        url: 'api/units', // Endpoint for adding units
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#unitModal').modal('hide');
            displayAlert('Unit created successfully', 'success');
            fetchUnits(); // Refresh the list after adding a new unit
            resetUnitForm(); // Reset the form after successful addition
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                ? xhr.responseJSON.message 
                : 'Failed to create unit';
            displayAlert(errorMessage, 'danger');
        }
    });
}

// Function to edit a unit
function editUnit(id) {
    $.ajax({
        url: `api/units/${id}`, // Endpoint for fetching unit details
        method: 'GET',
        success: function(response) {
            const unit = response;

            if (unit) {
                // Populate the form with the existing unit data
                $('#unitId').val(unit.id); // Store the unit id for updating
                $('#unitCode').val(unit.code);
                $('#unitArea').val(parseFloat(unit.area).toLocaleString('en-US', { maximumFractionDigits: 0 }));
                $('#unitPrice').val(parseFloat(unit.price).toLocaleString('en-US', { maximumFractionDigits: 0 }));

                // Update the modal title and button text
                $('#unitModalLabel').text('Edit Unit');
                $('#saveUnitButton').text(updateText);

                // Show the modal for editing
                $('#unitModal').modal('show');
            } else {
                displayAlert('No unit found for this ID.', 'danger');
            }
        },
        error: function(xhr) {
            displayAlert('Failed to fetch unit details for editing.', 'danger');
        }
    });
}

// Function to update an existing unit
function updateUnit(id) {
    const formData = {
        code: $('#unitCode').val(),
        area: $('#unitArea').val().replace(/,/g, ''), // Remove commas before sending
        price: $('#unitPrice').val().replace(/,/g, ''), // Remove commas before sending
    };

    $.ajax({
        url: `api/units/${id}`, // Endpoint for updating unit
        method: 'PUT',
        data: formData,
        success: function(response) {
            $('#unitModal').modal('hide');
            displayAlert('Unit updated successfully', 'success');
            fetchUnits(); // Refresh the list after update
            resetUnitForm(); // Reset the form after successful update
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                ? xhr.responseJSON.message 
                : 'Failed to update unit';
            displayAlert(errorMessage, 'danger');
        }
    });
}

// Function to delete a unit
function deleteUnit(id) {
    if (confirm('Are you sure you want to delete this unit?')) {
        $.ajax({
            url: `api/units/${id}`, // Endpoint for deleting unit
            method: 'DELETE',
            success: function() {
                displayAlert('Unit deleted successfully', 'success');
                fetchUnits(); // Refresh the list after deletion
            },
            error: function() {
                displayAlert('Failed to delete unit.', 'danger');
            }
        });
    }
}

// Display alert function
function displayAlert(message, type) {
    const alertContainer = document.getElementById("alertContainer");
    const alertElement = document.createElement("div");
    alertElement.className = `alert alert-${type} alert-dismissible fade show`;
    alertElement.role = "alert";
    alertElement.style.cssText = `
        font-size: 0.875rem;
        margin-left: 1rem;
    `;
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.appendChild(alertElement);

    // Remove the alert after 0.8 seconds
    setTimeout(() => {
        alertElement.classList.remove("show");
        alertElement.addEventListener("transitionend", () => alertElement.remove());
    }, 800);
}
