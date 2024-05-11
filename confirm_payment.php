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

// Get trip ID and other details from URL parameters
if (!isset($_POST['payment_method']) || !isset($_GET['trip_id']) || !isset($_GET['num_seats']) || !isset($_GET['total_fare'])) {
    header("Location: tripview.php"); // Redirect to view available trips if parameters are missing
    exit;
}
$payment_method = $_POST['payment_method'];
$trip_id = $_GET['trip_id'];
$num_seats = $_GET['num_seats'];
$total_fare = $_GET['total_fare'];

// Fetch trip details
$sql_trip = "SELECT * FROM trips WHERE TripID = $trip_id";
$result_trip = $conn->query($sql_trip);
if ($result_trip->num_rows == 0) {
    header("Location: tripview.php"); // Redirect to view available trips if trip ID is invalid
    exit;
}
$row_trip = $result_trip->fetch_assoc();

// Insert booking details into database
$sql_insert_booking = "INSERT INTO bookings (PassengerID, TripID, NumSeatsBooked, TotalFare, PaymentMethod) 
                       VALUES ((SELECT PassengerID FROM passenger WHERE Username = '{$_SESSION['passenger_username']}'), 
                               $trip_id, 
                               $num_seats, 
                               $total_fare, 
                               '$payment_method')";
if ($conn->query($sql_insert_booking) === TRUE) {
    // Redirect to success page
    header("Location: view_bookings.php");
    exit;
} else {
    echo "Error: " . $sql_insert_booking . "<br>" . $conn->error;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css"> <!-- Your custom styles -->
    <style>
      
        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-body {
            background-color: #f8f9fa;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
   <!-- Sidebar -->
   <div class="sidebar">
        <h2>Passenger Dashboard</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="passprofile.php"><i class="fas fa-user"></i> View/Edit Profile</a>
        <a href="tripview.php"><i class="fas fa-bus"></i> Book Ticket</a>
        <a href="view_bookings.php"><i class="fas fa-book-open"></i>  View Tickets </a>
     
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
    <div class="container">
        <h2>Confirm Payment</h2>
        <div class="card">
            <div class="card-header">
                Trip Details
            </div>
            <div class="card-body">
                <p><strong>Departure Date:</strong> <?php echo $row_trip['DepartureDate']; ?></p>
                <p><strong>Departure Time:</strong> <?php echo $row_trip['DepartureTime']; ?></p>
                <p><strong>Destination:</strong> <?php echo $row_trip['Destination']; ?></p>
                <p><strong>Number of Seats:</strong> <?php echo $num_seats; ?></p>
                <p><strong>Total Fare:</strong> K <?php echo number_format($total_fare, 2); ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Payment Method
            </div>
            <div class="card-body">
                <p><strong>Selected Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>
                <p>Please proceed with the payment according to the instructions provided for your selected payment method.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
