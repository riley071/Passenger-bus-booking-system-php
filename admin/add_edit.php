<?php
// Include database connection
include 'db_connect.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    // If not logged in, redirect to the login page
    header("Location: admin_login.php");
    exit(); // Stop further execution
}

// Retrieve vehicle ID from URL parameter
$vehicle_id = $_GET['id'];

// Retrieve vehicle information from database based on ID
$sql = "SELECT * FROM Vehicle WHERE VehicleID = $vehicle_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Vehicle found, display edit form with pre-filled data
    $row = $result->fetch_assoc();
    $model = $row['Model'];
    $year = $row['Year'];
    $mileage = $row['Mileage'];
    // Add more fields as needed
} else {
    echo "Vehicle not found";
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
    <link rel="stylesheet" href="css/style.css">
    </head>
<body>
<div class="topbar">
    <h1>Yathu-lja bus line </h1>
    
    <!-- Add more links as needed -->
</div>
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
  
    <div class="content">
    
 
     
        <div class="card mt-4">
            <div class="card-header">
   <!-- HTML form to edit vehicle details with pre-filled data -->

        <h2 class="text-center my-4">Add/Edit Vehicle</h2>
        <form action="save_vehicle.php" method="post">
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="year">Year:</label>
                <input type="text" class="form-control" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="mileage">Mileage:</label>
                <input type="text" class="form-control" id="mileage" name="mileage" required>
            </div>
            <!-- Add more input fields as needed -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
