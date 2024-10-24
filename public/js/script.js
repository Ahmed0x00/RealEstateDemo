

// Define a JavaScript function that handles route redirection
function Route(name) {
    window.location.href = name;
}

function Activate() {
    document.querySelector(".dropdown div").focus();
    console.log(document.querySelector(".dropdown div"));
}

$(document).ready(function () {
    // Toggle sidebar and overlay when the button is clicked
    $("#toggleBtn").click(function (event) {
        $("#Nav, #overlay3").toggleClass("show");
        event.stopPropagation(); // Prevent this click from bubbling up
    });

    // Hide the sidebar if the user clicks anywhere outside it
    $(document).click(function (event) {
        if (!$(event.target).closest("#Nav, #toggleBtn").length) {
            $("#Nav, #overlay3").removeClass("show");
        }
    });
});

// *********************************
// Function to load language file and set content

function setLanguage(lang) {
    fetch(`langs/${lang}.json`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load language file: ${response.statusText}`);
            }
            return response.json();
        })
        .then(content => {
            localStorage.setItem("language", lang);
            Object.entries(content).forEach(([key, value]) => {
                const element = document.getElementById(key);
                if (element) {
                    // Check if the element is an input, select, or text-based element
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        // Update placeholders for input and textarea elements
                        element.setAttribute('placeholder', value);
                    } else if (element.tagName === 'SELECT') {
                        // Update the options for select elements
                        const options = element.querySelectorAll('option');
                        options.forEach(option => {
                            const optionKey = `${option.id}Text`; // Construct the key for the option
                            if (content[optionKey]) {
                                option.innerHTML = content[optionKey];
                            }
                        });
                    } else {
                        // Default: update the innerText for standard elements
                        element.innerHTML = value;
                    }
                }
            });
        })
        .catch(error => {
            console.error(`Error setting language: ${error.message}`);
        });
}


// Automatically call setLanguage when the page loads
window.onload = function () {
    const savedLanguage = localStorage.getItem("language") || "en"; // Default to 'en' if not set
    setLanguage(savedLanguage);
};


function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.getElementById("passwordToggle");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
        toggleIcon.style.color = "gray";
    } else {
        passwordField.type = "password";
        toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
        toggleIcon.style.color = "gray";
    }
}

function toggleConfirmPasswordVisibility() {
    const confirmPasswordField = document.getElementById('confirm_password');
    const toggleConfirmIcon = document.getElementById('confirmPasswordToggle');

    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        toggleConfirmIcon.classList.replace('fa-eye-slash', 'fa-eye');
        toggleConfirmIcon.style.color = 'gray'; 
    } else {
        confirmPasswordField.type = 'password';
        toggleConfirmIcon.classList.replace('fa-eye', 'fa-eye-slash');
        toggleConfirmIcon.style.color = 'gray'; 
    }
}


function displayAlert(message, type) {
    // Define keywords or phrases that indicate a SQL error
    const sqlErrorKeywords = [
        'SQLSTATE',
        'Integrity constraint violation',
        'General error',
        'Cannot be null',
        'Duplicate entry',
    ];

    // Check if the message contains any SQL error keywords
    const isSqlError = sqlErrorKeywords.some(keyword => message.includes(keyword));

    // If it's an SQL error, do not display it
    if (isSqlError) {
        console.warn("SQL Error suppressed:", message); // Optionally log it for debugging
        return;
    }

    // Proceed to display the alert if not an SQL error
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



function logout() {
    fetch('/logout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Successfully logged out") {
            displayAlert("Logout successful! Redirecting to login page...", "success");
            setTimeout(() => {
                window.location.href = "/login"; // Redirect to login page
            }, 1000);
        } else if (data.message) {
            displayAlert(data.message, "danger"); // Display error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        displayAlert('An error occurred while logging out.', "danger");
    });
}
