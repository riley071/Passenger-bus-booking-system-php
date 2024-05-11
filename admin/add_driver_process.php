<?php
// Include database connection
include 'db_connect.php';

// Retrieve form data
$username = $_POST['username'];
$name = $_POST['name'];
$licenseNumber = $_POST['license_number'];
$certification = $_POST['certification'];
$performanceRating = $_POST['performance_rating'];
$suspended = $_POST['suspended'];

// Insert new driver into database
$sql = "INSERT INTO Driver (Username, Name, LicenseNumber, Certification, PerformanceRating, Suspended)
        VALUES ('$username', '$name', '$licenseNumber', '$certification', '$performanceRating', '$suspended')";

if ($conn->query($sql) === TRUE) {
    // Driver added successfully, suspend the driver if necessary
    if ($suspended === 'Yes') {
        // Calculate the end date of the suspension period (30 days from today)
        $suspension_end_date = date('Y-m-d', strtotime('+30 days'));

        // Update the Driver table to mark the driver as suspended and set the SuspensionEndDate
        $sql = "UPDATE Driver SET Suspended = 'Yes', SuspensionEndDate = '$suspension_end_date' WHERE Username = '$username'";

        // Execute the SQL query to suspend the driver
        if ($conn->query($sql) === TRUE) {
            echo "Driver suspended for 30 days."; // Output a success message
        } else {
            echo "Error updating record: " . $conn->error; // Output an error message if the query fails
        }
    }
    // Redirect back to add_driver.php
    header("Location: add_driver.php");
    exit(); // Stop further execution
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
