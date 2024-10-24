$(document).ready(function () {
    // Get language from localStorage, default to 'en' if not set
    const language = localStorage.getItem("language") || "en";

    // Set text based on language
    const updateText = language === "ar" ? "تحديث" : "Update";
    const deleteText = language === "ar" ? "حذف" : "Delete";

    // Array to hold resource data
    let resources = [];

    // Function to fetch all resources from the server
    function fetchResources(searchTerm = '') {
        $.ajax({
            url: "api/resources",
            method: "GET",
            success: function (data) {
                resources = data.resources;
                const filteredResources = resources.filter(resource => 
                    resource.id.toString().toLowerCase().includes(searchTerm.toLowerCase()) // Adjust based on the searchable field
                );
                renderResourceTable(filteredResources);
            },
            error: function () {
                displayAlert("Failed to load resources.", "danger");
            },
        });
    }

    // Function to render resources in the table
    function renderResourceTable(resources) {
        $('#resourceTableBody').empty(); // Clear table before appending new data

        if (resources.length > 0) {
            resources.forEach(resource => {
                const resourceRow = `
                    <tr>
                        <td>${resource.id}</td>
                        <td>${parseFloat(resource.quantity).toLocaleString('en-US', { maximumFractionDigits: 0 })}</td>
                        <td>${parseFloat(resource.price).toLocaleString('en-US', { maximumFractionDigits: 0 })}</td>
                        <td>
                            <button class="btn btn-warning action-btn" onclick="editResource(${resource.id})">${updateText}</button>
                            <button class="btn btn-danger action-btn" onclick="deleteResource(${resource.id})">${deleteText}</button>
                        </td>
                    </tr>
                `;
                $('#resourceTableBody').append(resourceRow);
            });
        } else {
            $('#resourceTableBody').html('<tr><td colspan="4" class="text-center no-records">There are no recorded Resources</td></tr>');
        }
    }

    // Function to reset the form
    function resetForm() {
        $("#resourceId").val("");
        $("#resourceQuantity").val("");
        $("#resourcePrice").val("");
        $("#resourceModalLabel").text("Add Resource");
        $("#saveResourceButton").text("Save"); // Reset button text
    }

    // Reset form and modal on hide
    $("#resourceModal").on("hidden.bs.modal", function () {
        resetForm();
    });

    // Event handler for formatting the price input with commas while typing
    $("#resourcePrice").on("input", function () {
        let value = $(this).val().replace(/,/g, ""); // Remove existing commas
        if (!isNaN(value) && value !== "") {
            // Format the number with commas
            value = parseFloat(value).toLocaleString("en-US", {
                maximumFractionDigits: 0,
            });
        }
        $(this).val(value);
    });

    // Event handler for adding or updating a resource
    $("#resourceForm").submit(function (e) {
        e.preventDefault();

        const resourceId = $("#resourceId").val();
        const quantity = $("#resourceQuantity").val();
        const price = $("#resourcePrice").val().replace(/,/g, ""); // Remove commas before submitting

        if (!quantity || !price) {
            displayAlert("Please fill in all the fields.", "warning");
            return;
        }

        const resourceData = { quantity, price };

        if (resourceId) {
            // Update existing resource
            $.ajax({
                url: `api/resources/${resourceId}`,
                method: "PUT",
                data: JSON.stringify(resourceData),
                contentType: "application/json",
                success: function () {
                    $("#resourceModal").modal("hide");
                    fetchResources(); // Refresh the resource list
                    displayAlert("Resource updated successfully.", "success");
                },
                error: function () {
                    displayAlert("Failed to update resource.", "danger");
                },
            });
        } else {
            // Add new resource
            $.ajax({
                url: "api/resources",
                method: "POST",
                data: JSON.stringify(resourceData),
                contentType: "application/json",
                success: function () {
                    $("#resourceModal").modal("hide");
                    fetchResources(); // Refresh the resource list
                    displayAlert("Resource added successfully.", "success");
                },
                error: function () {
                    displayAlert("Failed to add resource.", "danger");
                },
            });
        }
    });

    // Function to edit a resource
    window.editResource = function (id) {
        $.ajax({
            url: `api/resources/${id}`,
            method: "GET",
            success: function (response) {
                const resource = response;

                if (resource) {
                    $("#resourceId").val(resource.id);
                    $("#resourceQuantity").val(resource.quantity);
                    $("#resourcePrice").val(
                        parseFloat(resource.price).toLocaleString("en-US", {
                            maximumFractionDigits: 0,
                        })
                    );

                    $("#resourceModalLabel").text("Edit Resource");
                    $("#saveResourceButton").text(updateText);

                    $("#resourceModal").modal("show"); // Show the modal
                } else {
                    displayAlert("No resource found for this ID.", "warning");
                }
            },
            error: function () {
                displayAlert(
                    "Failed to fetch resource details for editing.",
                    "danger"
                );
            },
        });
    };

    // Function to delete a resource
    window.deleteResource = function (id) {
        if (confirm("Are you sure you want to delete this resource?")) {
            $.ajax({
                url: `api/resources/${id}`,
                method: "DELETE",
                success: function () {
                    fetchResources(); // Refresh the resource list
                    displayAlert("Resource deleted successfully.", "success");
                },
                error: function () {
                    displayAlert("Failed to delete resource.", "danger");
                },
            });
        }
    };

    // Event listener for the search input
    $("#searchInputResource").on("input", function () {
        const searchTerm = $(this).val(); // Get the current value of the input
        fetchResources(searchTerm); // Call the fetchResources function with the search term
    });

    // Initial fetch of resources
    fetchResources();
});
