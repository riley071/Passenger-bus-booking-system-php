<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
include 'db_connect.php';

// Get trip ID from URL parameter
if (!isset($_GET['trip_id'])) {
    header("Location: tripview.php"); // Redirect to view available trips if trip ID is not provided
    exit;
}
$trip_id = $_GET['trip_id'];

// Fetch trip details
$sql_trip = "SELECT * FROM trips WHERE TripID = $trip_id";
$result_trip = $conn->query($sql_trip);
if ($result_trip->num_rows == 0) {
    header("Location: tripview.php"); // Redirect to view available trips if trip ID is invalid
    exit;
}
$row_trip = $result_trip->fetch_assoc();

// Calculate total fare based on fare per kilometer and selected number of seats
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_seats = $_POST['num_seats']; // Corrected field name
    $fare_per_km = $row_trip['FarePerKm'];
    $total_fare = $num_seats * $fare_per_km;

    // Discount calculation based on passenger details
    $discount_percentage = 0;
    $passenger_age = $_POST['age'];
    $is_student = isset($_POST['student']) ? true : false;
    $is_inter_regional = isset($_POST['inter_regional']) ? true : false;
    $is_frequent_traveler = isset($_POST['frequent_traveler']) ? true : false;

    // Children discount
    if ($passenger_age < 16) {
        $discount_percentage += 50;
    }

    // Elderly discount
    if ($passenger_age > 70) {
        $discount_percentage += 50;
    }

    // Student discount
    if ($is_student) {
        $discount_percentage += 25;
    }

    // Inter-regional discount
    if ($is_inter_regional) {
        $discount_percentage += 10;
    }

    // Kabwerebwere discount (frequent traveler)
    if ($is_frequent_traveler) {
        // Check if passenger has made at least 5 trips in the current month
        $current_month = date('m');
        $current_year = date('Y');
        $sql_frequent_traveler = "SELECT COUNT(*) AS num_trips FROM bookings 
                                WHERE PassengerID = '{$_SESSION['passenger_username']}' 
                                AND MONTH(BookingDate) = $current_month 
                                AND YEAR(BookingDate) = $current_year";
        $result_frequent_traveler = $conn->query($sql_frequent_traveler);
        if ($result_frequent_traveler->num_rows > 0) {
            $row_frequent_traveler = $result_frequent_traveler->fetch_assoc();
            if ($row_frequent_traveler['num_trips'] >= 5) {
                $discount_percentage = 100; // 100% discount for Kabwerebwere
            }
        }
    }

    // Apply discount
    $total_discount = ($discount_percentage / 100) * $total_fare;
    $total_fare_after_discount = $total_fare - $total_discount;

    // Subtract the booked seats from available seats
    $available_seats = $row_trip['AvailableSeats'] - $num_seats;

    // Update available seats in the trips table
    $sql_update_seats = "UPDATE trips SET AvailableSeats = $available_seats WHERE TripID = $trip_id";
    if ($conn->query($sql_update_seats) === FALSE) {
        echo "Error updating available seats: " . $conn->error;
        exit;
    }

   // Insert booking details into database
$sql_insert_booking = "INSERT INTO bookings (PassengerID, TripID, NumSeatsBooked, TotalFare, PaymentMethod) VALUES ((SELECT PassengerID FROM passenger WHERE Username = '{$_SESSION['passenger_username']}'), $trip_id, $num_seats, $total_fare_after_discount, '$payment_method')";
if ($conn->query($sql_insert_booking) === TRUE) {
    // Redirect to payment page
    header("Location: payment.php?trip_id=$trip_id&num_seats=$num_seats&total_fare=$total_fare_after_discount&payment_method=$payment_method");
    exit;
} else {
    echo "Error: " . $sql_insert_booking . "<br>" . $conn->error;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css"> <!-- Your custom styles -->
    <style>
        /* Improved sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background color */
            padding-top: 50px;
            overflow-y: auto; /* Add scrollbar for overflow */
        }

        .sidebar h2 {
            color: #fff; /* White text color */
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            color: #d1d8e0; /* Light text color */
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057; /* Darker background color on hover */
            color: #fff; /* White text color on hover */
        }

        .sidebar hr {
            border-top: 1px solid #6c757d; /* Gray border */
            margin: 20px 0;
        }

        /* Content area styles */
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f0f0f0;
        }

        h4 {
            color: #007bff; /* Blue text color */
            margin-top: 0;
        }

        p {
            color: #6c757d; /* Gray text color */
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-check {
            margin-top: 10px;
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
        <a href="passpayment.php"><i class="fas fa-credit-card"></i> Make Payment</a>
         <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
  
    <!-- Content area -->
    <div class="content">
        
  
    <div class="card mb-4">
        <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-book"></i> Book Ticket</h4>
    </div>

    <div class="container">
           <div>
            <h3>Trip Details</h3>
           
            <p><strong>Trip ID:</strong> <?php echo $row_trip['TripID']; ?></p>
            <p><strong>DepartureTime:</strong> <?php echo $row_trip['DepartureTime']; ?></p>
            <p><strong>To:</strong> <?php echo $row_trip['Destination']; ?></p>
            <p><strong>DepartureDate:</strong> <?php echo $row_trip['DepartureDate']; ?></p>
            <p><strong>Fare Per Km:</strong> <?php echo $row_trip['FarePerKm']; ?></p>
        </div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?trip_id=' . $trip_id; ?>">
            <div class="form-group">
                <label for="num_seats">Number of Seats:</label>
                <input type="number" id="num_seats" name="num_seats" min="1" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="1" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="student" name="student">
                <label class="form-check-label" for="student">Student</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="inter_regional" name="inter_regional">
                <label class="form-check-label" for="inter_regional">Inter-Regional Travel</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="frequent_traveler" name="frequent_traveler">
                <label class="form-check-label" for="frequent_traveler">Frequent Traveler (Kabwerebwere)</label>
            </div>
            <button type="submit" class="btn btn-primary">Book Ticket</button>
        </form>
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
