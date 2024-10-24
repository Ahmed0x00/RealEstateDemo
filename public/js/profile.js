document.addEventListener('DOMContentLoaded', () => {
    fetch('/user')
    .then(response => response.json())
    .then(data => {
        const user = data.user;
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('userRole').textContent = user.role;

        // Handle optional fields
        const optionalFields = ['phone', 'actions', 'client_id', 'employee_id'];
        const iconMap = {
            phone: 'fa-phone',
            actions: 'fa-tasks',
            client_id: 'fa-user-circle',
            employee_id: 'fa-id-card',
        };
        const colorMap = {
            phone: 'text-success', // green
            actions: 'text-warning', // yellow
            client_id: 'text-info', // light blue
            employee_id: 'text-danger', // red
        };

        const optionalCards = document.getElementById('optionalCards');
        const language = localStorage.getItem('language') || 'en'; // Default to English

        const fieldTranslations = {
            phone: language === 'ar' ? 'رقم الهاتف' : 'PHONE',
            actions: language === 'ar' ? 'الإجراءات' : 'ACTIONS',
            client_id: language === 'ar' ? 'معرّف العميل' : 'CLIENT ID',
            employee_id: language === 'ar' ? 'رقم هوية الموظف' : 'EMPLOYEE ID',
        };

        optionalFields.forEach(field => {
            if (user[field] !== null) {
                const card = document.createElement('div');
                card.className = 'col-sm-3'; // Use Bootstrap's column size for consistent layout

                const iconClass = iconMap[field] || 'fa-info-circle';
                const colorClass = colorMap[field] || 'text-secondary'; // Default color

                card.innerHTML = `
                    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas ${iconClass} ${colorClass}"></i> ${fieldTranslations[field]}
                            </h5>
                            <p class="card-text text-primary">${user[field]}</p>
                        </div>
                    </div>
                `;
                optionalCards.appendChild(card);
            }
        });
    });


    // Handle Change Password form submission
    document.getElementById('changePasswordForm').addEventListener('submit', (event) => {
        event.preventDefault();
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validate if new password and confirmation match
        if (newPassword !== confirmPassword) {
            displayAlert('New password and confirmation do not match', 'danger');
            return;
        }

        // Send the password change request to the server
        fetch('/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Password changed successfully') {
                displayAlert(data.message, 'success');
                document.getElementById('changePasswordForm').reset();
            } else {
                displayAlert('Password change failed. Please try again.', 'danger');
            }         
        })
        .catch(error => {
            console.error('Error changing password:', error);
            displayAlert('An unexpected error occurred. Please try again.', 'danger');
        });
    });
});
