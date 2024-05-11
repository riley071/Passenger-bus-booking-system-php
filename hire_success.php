

<?php
// Start session

session_start();


// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
?>
<?php
// Retrieve details from the URL
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$total_distance = $_GET['total_distance'] ?? '';
$total_cost = $_GET['total_cost'] ?? '';
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
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Bus Hired Successfully!</h4>
            <p>Below are the details of your bus hire:</p>
            <ul>
                <li>Start Date: <?php echo htmlspecialchars($start_date); ?></li>
                <li>End Date: <?php echo htmlspecialchars($end_date); ?></li>
                <li>Total Distance (in km): <?php echo htmlspecialchars($total_distance); ?></li>
                <li>Total Cost: K<?php echo number_format($total_cost, 2); ?></li>
            </ul>
        </div>
        <button class="btn btn-primary print-hiden" onclick="window.print()">Print</button>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>
