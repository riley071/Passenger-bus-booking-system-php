<?php
// Include database connection
include 'db_connect.php';

// Retrieve driver performance and safety records from the database
$sql = "SELECT * FROM Driver";
$result = $conn->query($sql);

// Check if there are any drivers
if ($result->num_rows > 0) {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="driver_report.csv"');
    
    // Open file handle
    $output = fopen('php://output', 'w');

    // Output CSV headers
    fputcsv($output, array('Driver ID', 'Username', 'Name', 'Performance Rating', 'Accident History'));

    // Output data of each driver
    while ($row = $result->fetch_assoc()) {
        // Output data rows in CSV format
        fputcsv($output, $row);
    }

    // Close file handle
    fclose($output);
} else {
    echo "No drivers found.";
}

// Close connection
$conn->close();
?>
