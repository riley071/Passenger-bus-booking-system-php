<?php
// Include database connection
include 'db_connect.php';

// Check if PassengerID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $passenger_id = $_GET['id'];

    // Delete passenger from the database based on PassengerID
    $sql = "DELETE FROM Passenger WHERE PassengerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $passenger_id);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Passenger deleted successfully.";
    } else {
        echo "Failed to delete passenger.";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Passenger ID not provided.";
}

// Close connection
$conn->close();
?>
