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
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query to fetch available trips
$sql = "SELECT * FROM trips WHERE AvailableSeats > 0";
$result = $conn->query($sql);
if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        <a href="bushiring.php"><i class="fas fa-book-open"></i>  Bus hire </a>
      
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
  
    <!-- Content area -->
    <div class="content">
        
    <h4 class="mb-0"><i class="fas fa-open"></i> View Available Trips</h4>
    <div class="card mb-4">
      
       
    </div>
     
        <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Destination</th>
                    <th>Available Seats</th>
                    <th>Fare Per Km</th>
                    <th>Action</th> <!-- Add this column for the action -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["DepartureDate"] . "</td>";
                        echo "<td>" . $row["DepartureTime"] . "</td>";
                        echo "<td>" . $row["Destination"] . "</td>";
                        echo "<td>" . $row["AvailableSeats"] . "</td>";
                        echo "<td>" . $row["FarePerKm"] . "</td>";
                        // Add button or link for selecting the trip
                        echo "<td><a href='booking.php?trip_id=" . $row["TripID"] . "' class='btn btn-primary'>Select Trip</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No available trips</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
