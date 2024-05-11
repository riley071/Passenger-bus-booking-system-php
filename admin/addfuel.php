<?php
// Include database connection
include 'db_connect.php';

// Fetch list of vehicles
$sql = "SELECT * FROM vehicle";
$result = $conn->query($sql);
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
    <div class="content">
    
 
     
        <div class="card mt-4">
            <div class="card-header">
      <h2>Record Fuel</h2>
      <div class="card mt-4">
<div class="card-body">
    <?php
    // Check if success parameter is set in the URL
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        // Display success alert
        echo '<div class="alert alert-success" role="alert">
                  Fuel refill recorded successfully!
              </div>';
    }
    ?>
    <form action="record_fuel_refill.php" method="post">
        <div class="form-group row">
            <label for="vehicle_id" class="col-sm-3 col-form-label">Vehicle Model:</label>
            <div class="col-sm-9">
                <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                    <option value="" selected disabled>Select Vehicle Model</option>
                    <?php
                    // Output options for vehicle models
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["VehicleID"] . '">' . $row["Model"] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="refill_date" class="col-sm-3 col-form-label">Refill Date:</label>
            <div class="col-sm-9">
                <input type="date" class="form-control" id="refill_date" name="refill_date" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="fuel_quantity" class="col-sm-3 col-form-label">Fuel Quantity:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="fuel_quantity" name="fuel_quantity" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="cost" class="col-sm-3 col-form-label">Cost:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="cost" name="cost" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-block">Record Fuel Refill</button>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
