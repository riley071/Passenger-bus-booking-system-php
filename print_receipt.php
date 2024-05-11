<?php
session_start();

// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
include 'db_connect.php';

// Retrieve passenger ID from the database based on the username stored in the session
$passenger_username = $_SESSION['passenger_username'];
$sql_passenger_id = "SELECT PassengerID FROM passenger WHERE username = '$passenger_username'";
$result_passenger_id = $conn->query($sql_passenger_id);

if ($result_passenger_id && $result_passenger_id->num_rows > 0) {
    $row_passenger_id = $result_passenger_id->fetch_assoc();
    $passenger_id = $row_passenger_id['PassengerID'];

    // Check if booking ID is provided in the URL
    if(isset($_GET['booking_id'])) {
        $booking_id = $_GET['booking_id'];

        // Query to retrieve booking details for the logged-in passenger
        $sql = "SELECT * FROM bookings WHERE BookingID = $booking_id AND PassengerID = $passenger_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Fetch booking details
            $row = $result->fetch_assoc();

            // Display receipt
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Receipt</title>
                <style>
                    /* CSS styles for receipt */
                    /* Add your custom CSS styles here */
                </style>
            </head>
            <body>
                <h2>Booking Receipt</h2>
                <p><strong>Booking ID:</strong> <?php echo $row['BookingID']; ?></p>
                <p><strong>Trip ID:</strong> <?php echo $row['TripID']; ?></p>
                <p><strong>Booking Date:</strong> <?php echo $row['BookingDate']; ?></p>
                <p><strong>Number of Seats:</strong> <?php echo $row['NumSeatsBooked']; ?></p>
                <p><strong>Total Fare:</strong> <?php echo $row['TotalFare']; ?></p>
                <p><strong>Payment Method:</strong> <?php echo $row['PaymentMethod']; ?></p>
                <!-- Add more details as needed -->

                <!-- Add a button to go back or print the receipt -->
                <button onclick="window.print()">Print Receipt</button>
            </body>
            </html>
            <?php
        } else {
            echo "Booking not found or you don't have permission to view this booking.";
        }
    } else {
        echo "Booking ID is not provided.";
    }
} else {
    echo "Passenger ID not found.";
}

$conn->close();
?>
