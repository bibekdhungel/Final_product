<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificates</title>
    <style>
        body {
            background-color: #4d0b5c; /* Set background color */
            color: white; /* Set text color to white for better visibility */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            color: white; /* Set table text color to white */
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            color: #4d0b5c; /* Set header text color */
        }
        tr:nth-child(even) {
            background-color: #6b4d82;
        }
    </style>
</head>
<body>
    <h1>Medical Certificates</h1>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Sick Date</th>
                <th>View Certificate</th>
            </tr>
        </thead>
        <tbody id="medical-certificates-list">
            <!-- Rows will be added here by JavaScript -->
        </tbody>
    </table>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch data from PHP script
            fetch('fetch_medical_certificates.php')
                .then(response => response.json())
                .then(data => {
                    // Get the table body element
                    const certificatesList = document.getElementById('medical-certificates-list');

                    // Process and display data in table rows
                    data.forEach(cert => {
                        const row = document.createElement('tr');
                        row.dataset.pdfPath = cert.certificate_file_path;
                        row.innerHTML = `
                            <td>${cert.student_id}</td>
                            <td>${cert.student_name}</td>
                            <td>${cert.sick_date}</td>
                            <td><a href="${cert.certificate_file_path}" target="_blank">View Certificate</a></td>
                        `;
                        certificatesList.appendChild(row);
                    });

                    // Add click event listener to each row to open PDF in new tab
                    certificatesList.querySelectorAll('tr').forEach(row => {
                        row.addEventListener('click', function() {
                            window.open(this.dataset.pdfPath, "_blank");
                        });
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
</body>
</html>
