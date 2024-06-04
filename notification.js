function approveBooking(booking) {
    console.log('Approve button clicked!'); // Log a message to the console
    fetch('store_student.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(booking),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Student enrolled successfully:', data);
        fetchBookings(); // Refresh the bookings after approving
    })
    .catch(error => console.error('Error enrolling student:', error));
}
