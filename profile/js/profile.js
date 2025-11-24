document.addEventListener('DOMContentLoaded', function() {
    loadProfileData();

    // Image Preview
    document.getElementById('profile_pic').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Handle Profile Update
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const msgDiv = document.getElementById('profileMessage');

        fetch('api/update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                loadProfileData(); // Refresh display
            } else {
                msgDiv.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
            }
        });
    });

    // Handle Password Change
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const current = this.querySelector('[name="current_password"]').value;
        const newPass = this.querySelector('[name="new_password"]').value;
        const confirm = this.querySelector('[name="confirm_password"]').value;
        const msgDiv = document.getElementById('passwordMessage');

        if(newPass !== confirm) {
            msgDiv.innerHTML = '<div class="alert alert-error">New passwords do not match</div>';
            return;
        }

        fetch('api/change_password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                current_password: current,
                new_password: newPass
            })
        })
        .then(response => response.json())
        .then(data => {
            msgDiv.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'error'}">${data.message}</div>`;
            if(data.success) this.reset();
        });
    });
});

function loadProfileData() {
    fetch('api/get_profile_data.php')
        .then(response => response.json())
        .then(response => {
            if(response.success) {
                const user = response.data;
                
                // Populate Forms
                document.getElementById('full_name').value = user.full_name || '';
                document.getElementById('phone').value = user.phone || '';
                document.getElementById('date_of_birth').value = user.date_of_birth || '';
                document.getElementById('education_level').value = user.education_level || 'High School';
                document.getElementById('interests').value = user.interests || '';
                
                // Populate Sidebar
                document.getElementById('displayFullName').textContent = user.full_name || user.username;
                document.getElementById('displayEmail').textContent = user.email;
                document.getElementById('displayEducation').textContent = user.education_level || 'Student';
                
                if(user.profile_picture) {
                    document.getElementById('profileImagePreview').src = 'uploads/profiles/' + user.profile_picture;
                }
            }
        });
}