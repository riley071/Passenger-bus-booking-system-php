<?php
// Start session
session_start();

// Include database connection
include 'db_connect.php';

// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Retrieve passenger ID from session
$passenger_username = $_SESSION['passenger_username'];

// Retrieve PassengerID from the passenger table based on passenger_username
$query = "SELECT PassengerID FROM passenger WHERE Username = '$passenger_username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $passenger_id = $row['PassengerID'];
} else {
    // Handle the case where PassengerID is not found
    echo "PassengerID not found";
    exit;
}

// Check if form data is set and not empty
if (empty($_POST['start_date']) || empty($_POST['end_date']) || empty($_POST['total_distance'])) {
    // Redirect back with error message if form data is not set or empty
    header("Location: bushiring.php?error=Form%20data%20is%20missing%20or%20empty");
    exit;
}

// Sanitize and validate form data
$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
$end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
$total_distance = mysqli_real_escape_string($conn, $_POST['total_distance']);

// Calculate total cost
$total_cost = calculateTotalCost($total_distance, $start_date, $end_date);

// Insert hiring details into the database
$sql = "INSERT INTO bushiring (PassengerID, StartDate, EndDate, TotalDistance, TotalCost) 
        VALUES ('$passenger_id', '$start_date', '$end_date', '$total_distance', '$total_cost')";

if ($conn->query($sql) === TRUE) {
    // Hiring details inserted successfully
    header("Location: hire_success.php?start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&total_distance=" . urlencode($total_distance) . "&total_cost=" . urlencode($total_cost));
    // Redirect to success page
    exit();
} else {
    // Error occurred
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();

// Function to calculate total cost based on total distance and dates
function calculateTotalCost($distance, $start_date, $end_date) {
    // Assuming cost per km is K1,000
    $cost_per_km = 1000;

    // Calculate total days
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    $total_days = ceil(($end_timestamp - $start_timestamp) / (60 * 60 * 24)); // Convert seconds to days and round up

    // Calculate total cost
    $total_cost = $distance * $cost_per_km;
    if ($total_days > 1) {
        $total_cost += 100000; // Additional charge if trip spans more than a day
    }

    return $total_cost;
}
?>
