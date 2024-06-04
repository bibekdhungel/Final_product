// medicalcertificate.js

// Add an event listener to the form submission
document.getElementById("certificateForm").addEventListener("submit", function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    
    // Get the form data
    const formData = new FormData(this);
    
    // You can perform additional validation or processing here
    
    // Example: Log the form data to the console
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    // Example: Send the form data to the server using fetch API
    fetch("medicalcertificate.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.text();
    })
    .then(data => {
        console.log(data); // Log the response from the server
        // You can update the UI or show a success message here
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors or show an error message to the user
    });
});
