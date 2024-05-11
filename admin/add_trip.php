<?php
// Include database connection
include 'db_connect.php';

// Retrieve form data
$departure_date = $_POST['departure_date'];
$departure_time = $_POST['departure_time'];
$destination = $_POST['destination'];
$fare_per_km = $_POST['fare_per_km'];
$vehicle_id = $_POST['vehicle_id']; // retrieve the selected vehicle ID

// Check if available_seats is set
if (isset($_POST['available_seats'])) {
    $available_seats = $_POST['available_seats'];
} else {
    // Handle the case where available_seats is not set
    $available_seats = 0; // Default value or handle error appropriately
}

// Insert trip details into the database
$sql = "INSERT INTO trips (DepartureDate, DepartureTime, Destination, AvailableSeats, FarePerKm, VehicleID) 
        VALUES ('$departure_date', '$departure_time', '$destination', $available_seats, $fare_per_km, $vehicle_id)";

if ($conn->query($sql) === TRUE) {
    // Trip added successfully
    header("Location: admindashboard.php"); // Redirect to admin dashboard
    exit();
} else {
    // Error occurred
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
