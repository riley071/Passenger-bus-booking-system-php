<?php
// Start session
session_start();

// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
include 'db_connect.php';

// Retrieve passenger username from session
$passenger_username = $_SESSION['passenger_username'];

// Fetch bus hires for the logged-in passenger
$sql = "SELECT * FROM bushiring WHERE PassengerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $passenger_username);
$stmt->execute();
$result = $stmt->get_result();

// Close statement
$stmt->close();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hires</title>
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
        <a href="view_hires.php"><i class="fas fa-bus"></i> View Hires</a> <!-- Link to View Hires page -->
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
    <div class="container mt-5">
        <h2>View Hires</h2>
        <?php if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Distance (km)</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['StartDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['EndDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['TotalDistance']); ?></td>
                    <td>K<?php echo number_format($row['TotalCost'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No bus hires found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
