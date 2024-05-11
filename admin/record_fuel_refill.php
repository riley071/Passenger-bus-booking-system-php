<?php
// Include database connection
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $vehicle_id = $_POST['vehicle_id'];
    $refill_date = $_POST['refill_date'];
    $fuel_quantity = $_POST['fuel_quantity'];
    $cost = $_POST['cost'];

    // Prepare SQL statement to insert fuel refill data into the database
    $sql = "INSERT INTO fuel_refills (VehicleID, RefillDate, FuelQuantity, Cost) 
            VALUES ('$vehicle_id', '$refill_date', '$fuel_quantity', '$cost')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to the fuel refill form with success parameter
        header("Location: addfuel.php?success=1");
        exit();
    } else {
        // If an error occurs, display error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
