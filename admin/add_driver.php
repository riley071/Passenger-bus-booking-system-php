<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    // If not logged in, redirect to the login page
    header("Location: admin_login.php");
    exit(); // Stop further execution
}

// Admin is logged in, continue with the page content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Driver</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
        <!-- Sidebar -->
        <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="admindashboard.php"><i class="fas fa-tachometer-alt icon"></i> Dashboard</a>
        <!-- Dropdown for managing drivers -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" id="manageDriversDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user icon"></i>   Manage Drivers
            </a>
            <div class="dropdown-menu" aria-labelledby="manageDriversDropdown">
            <a class="dropdown-item" href="add_driver.php"> Add New Driver</a>
                <a class="dropdown-item" href="adminviewdriver.php"> View Drivers</a>
                <a class="dropdown-item" href="add_edit.php"> Edit Drivers</a>
            </div>
        </div>
        <!-- Dropdown for adding drivers -->
        <div class="dropdown">
        <a href="#" class="dropdown-toggle" id="manageFleetDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-truck icon"></i>Manage Fleet
</a>
<div class="dropdown-menu" aria-labelledby="manageFleetDropdown">
    <a class="dropdown-item" href="add_vehicle.php"> Add Vehicle</a>
    <a class="dropdown-item" href="view_vehicle.php"> View Vehicles</a>
</div>
</div>
<div class="dropdown">
<a href="#" class="dropdown-toggle" id="manageFuelDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-gas-pump icon"></i> Manage Fuel
</a>
<div class="dropdown-menu" aria-labelledby="manageFuelDropdown">
    <a class="dropdown-item" href="addfuel.php">Record Fuel Fill-Up</a>
    <a class="dropdown-item" href="view_fuel_refill.php">View Fuel Fill-Up</a>
</div>
</div>
        <a href="adminmanagepas.php"><i class="fas fa-users icon"></i>Manage Passengers</a>
        <a href="add_booking.php"><i class="fas fa-bus icon"></i>Add Booking</a>
        <hr>
        <a href="Viewavailabletrips.php"><i class="fas fa-bus icon"></i>View Available Booking</a>
        <a href="adminviewbook.php"><i class="fas fa-book icon"></i>Bookings</a>
        <a href="reports.php"><i class="fas fa-chart-bar icon"></i>Reports</a>
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
    </div>
     <div class="content">
      
    <div class="card mt-4">
    <div class="card-header">
    <div class="container mt-4">
    <div class="card mt-4">
    <div class="card-header">
        <h2 class="mb-0">Add Driver</h2>
    </div>
    <div class="card-body">
        <?php
        // Check if success parameter is set in the URL
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            // Display success alert
            echo '<div class="alert alert-success" role="alert">
                      Driver added successfully!
                  </div>';
        }
        ?>
        <form action="add_driver_process.php" method="post">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="license_number" class="col-sm-3 col-form-label">License Number:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="license_number" name="license_number" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="certification" class="col-sm-3 col-form-label">Certification:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="certification" name="certification" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="performance_rating" class="col-sm-3 col-form-label">Performance Rating:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="performance_rating" name="performance_rating" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="suspended" class="col-sm-3 col-form-label">Suspended:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="suspended" name="suspended" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Add Driver</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
