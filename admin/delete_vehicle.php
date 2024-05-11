<?php
// Include database connection
include 'db_connect.php';

// Retrieve vehicle ID from URL parameter
$vehicle_id = $_GET['id'];

// Delete vehicle from database based on ID
$sql = "DELETE FROM Vehicle WHERE VehicleID = $vehicle_id";

if ($conn->query($sql) === TRUE) {
    echo "Vehicle deleted successfully";
} else {
    echo "Error deleting vehicle: " . $conn->error;
}
?>
