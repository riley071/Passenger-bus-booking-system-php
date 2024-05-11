
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
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <!-- Dropdown for adding drivers -->
        
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
    <!-- Content area -->
    <div class="content">
    

     
        <div class="card mt-4">
            <div class="card-header">
            <h2>Add Trip</h2>
        <div class="container">
        
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Enter Trip Details</h4>
                </div>
                <div class="card-body">
                    <form action="add_trip.php" method="POST">
                        <div class="form-group">
                            <label for="departure_date">Departure Date:</label>
                            <input type="date" class="form-control" id="departure_date" name="departure_date" required>
                        </div>
                        <div class="form-group">
                            <label for="departure_time">Departure Time:</label>
                            <input type="time" class="form-control" id="departure_time" name="departure_time" required>
                        </div>
                        <div class="form-group">
                            <label for="destination">Destination:</label>
                            <input type="text" class="form-control" id="destination" name="destination" required>
                        </div>
                        <div class="form-group">
                        <label for="available_seats">Available Seats:</label>
                        <input type="number" class="form-control" id="available_seats" name="available_seats" required>
                    </div>
                        <div class="form-group">
    <label for="vehicle_id">Select Vehicle:</label>
    <select class="form-control" id="vehicle_id" name="vehicle_id" required>
        <option value="">Select Vehicle</option>
        <?php
        // Include database connection
        include 'db_connect.php';
        
        // Fetch vehicles from the database
        $sql = "SELECT * FROM vehicle";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['VehicleID'] . "'>" . $row['Model'] . " (" . $row['VehicleNumber'] . ")" . "</option>";
            }
        } else {
            echo "<option value='' disabled>No vehicles available</option>";
        }
        ?>
    </select>
</div>


                        <div class="form-group">
                            <label for="fare_per_km">Fare Per Km:</label>
                            <input type="number" step="0.01" class="form-control" id="fare_per_km" name="fare_per_km" required>
                        </div>
                        <!-- You can add more fields here if needed -->
                        <button type="submit" class="btn btn-primary">Add Trip</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <!-- Include your scripts here -->
</body>
</html>
