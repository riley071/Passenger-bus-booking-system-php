<?php
 // Include database connection
 include 'db_connect.php';
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php"); // Redirect to admin login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Custom CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library --> <!-- Font Awesome -->
  
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="admindashboard.php"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a>
        <!-- Dropdown for managing drivers -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" id="manageDriversDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user icon"></i>Manage Drivers
            </a>
            <div class="dropdown-menu" aria-labelledby="manageDriversDropdown">
            <a class="dropdown-item" href="add_driver.php">Add New Driver</a>
                <a class="dropdown-item" href="adminviewdriver.php">View Drivers</a>
                <a class="dropdown-item" href="add_edit.php">Edit Drivers</a>
            </div>
        </div>
      
        <div class="dropdown">
        <a href="#" class="dropdown-toggle" id="manageFleetDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-truck icon"></i>Manage Fleet
</a>
<div class="dropdown-menu" aria-labelledby="manageFleetDropdown">
    <a class="dropdown-item" href="add_vehicle.php">Add Vehicle</a>
    <a class="dropdown-item" href="view_vehicle.php">View Vehicles</a>
</div>
</div>
<div class="dropdown">
<a href="#" class="dropdown-toggle" id="manageFuelDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-gas-pump icon"></i>Manage Fuel
</a>
<div class="dropdown-menu" aria-labelledby="manageFuelDropdown">
    <a class="dropdown-item" href="addfuel.php">Record Fuel Fill-Up</a>
    <a class="dropdown-item" href="view_fuel_refill.php">View Fuel Fill-Up</a>
</div>
</div>
        <a href="adminmanagepas.php"><i class="fas fa-users icon"></i>Manage Passengers</a>
        <hr>
        <a href="Viewavailabletrips.php"><i class="fas fa-bus icon"></i>View Available Booking</a>
        <a href="add_booking.php"><i class="fas fa-bus icon"></i>Add Booking</a>
        <a href="adminviewbook.php"><i class="fas fa-book icon"></i>Bookings</a>
        <a href="reports.php"><i class="fas fa-chart-bar icon"></i>Reports</a>
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
    </div>
    <!-- Content area -->
    <div class="content">
    
 
     
        <div class="card mt-4">
            <div class="card-header">
        <h4 class="mb-0">View Drivers</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Driver ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>License Number</th>
                        <th>Certification</th>
                        <th>Performance Rating</th>
                        <th>Suspension Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve driver information from the database
                    $sql = "SELECT * FROM Driver";
                    $result = $conn->query($sql);

                    // Check if there are any drivers
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["DriverID"] . "</td>";
                            echo "<td>" . $row["Username"] . "</td>";
                            echo "<td>" . $row["Name"] . "</td>";
                            echo "<td>" . $row["LicenseNumber"] . "</td>";
                            echo "<td>" . $row["Certification"] . "</td>";
                            echo "<td>" . $row["PerformanceRating"] . "</td>";
                            echo "<td>" . $row["SuspensionEndDate"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No drivers found.</td></tr>";
                    }
                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <form action="generate_report.php" method="post">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
        </div>
    </div>
</div>



</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
