const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const bthPopup = document.querySelector('.bthLogin-popup');


registerLink.addEventListener('click', () => wrapper.classList.add('active'));
loginLink.addEventListener('click', () => wrapper.classList.remove('active'));
bthPopup.addEventListener('click', () => wrapper.classList.add('active-popup'));
iconClose.addEventListener('click', () => wrapper.classList.remove('active-popup'));
// Function to close the medform container


// Function to fetch notifications via AJAX
function fetchNotifications() {
    // Make an AJAX request to fetch notifications
    $.ajax({
        url: 'fetch_notifications.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Clear existing notifications
            $('#notification-list').empty();

            // Add new notifications
            response.forEach(function(notification) {
                $('#notification-list').append('<div class="notification">' + notification.message + '</div>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching notifications:', error);
        }
    });
}

// Fetch notifications every 10 seconds
setInterval(fetchNotifications, 10000); // Adjust interval as needed
