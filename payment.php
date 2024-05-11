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
if (!isset($_GET['trip_id']) || !isset($_GET['num_seats']) || !isset($_GET['total_fare'])) {
    header("Location: tripview.php"); // Redirect to view available trips if parameters are missing
    exit;
}
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css"> <!-- Your custom styles -->
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Passenger Dashboard</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="passprofile.php"><i class="fas fa-user"></i> View/Edit Profile</a>
        <a href="tripview.php"><i class="fas fa-bus"></i> Book Ticket</a>
        <a href="view_bookings.php"><i class="fas fa-book-open"></i>  View Tickets </a>
        <a href="bushiring.php"><i class="fas fa-book-open"></i>  Bus hire </a>
       
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>

    
      
        <h4 class="mb-0"><i class="fas fa-cash"></i>  Payment</</h4>
    </div>

    <div class="container">
      
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
        <!-- Payment options -->
        <div class="card">
            <div class="card-header">
                Payment Options
            </div>
            <div class="card-body">
                <p>Select your preferred payment method:</p>
                <form action="confirm_payment.php?trip_id=<?php echo $trip_id; ?>&num_seats=<?php echo $num_seats; ?>&total_fare=<?php echo $total_fare; ?>" method="POST">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_bank_transfer" value="bank_transfer" required>
                        <label class="form-check-label" for="payment_bank_transfer">
                            Bank Transfer
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" required>
                        <label class="form-check-label" for="payment_cash">
                            Cash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_mobile_money" value="mobile_money" required>
                        <label class="form-check-label" for="payment_mobile_money">
                            Mobile Money
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Disable submit button after click to prevent multiple submissions
        document.getElementById("bookingForm").addEventListener("submit", function() {
            document.getElementById("submitBtn").disabled = true;
        });
    </script>

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
