// JavaScript code to handle interactions with medical certificates

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Fetch data from PHP script
    fetch('fetch_medical_certificates.php')
        .then(response => response.json())
        .then(data => {
            // Process and display data in table rows
            const certificatesList = document.getElementById('medical-certificates-list');
            data.forEach(cert => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${cert.student_id}</td>
                    <td>${cert.student_name}</td>
                    <td>${cert.sick_date}</td>
                    <td><a href="${cert.certificate_file_path}" target="_blank">View Certificate</a></td>
                `;
                certificatesList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
