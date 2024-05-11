<?php
// Include database connection
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicle_id = $_POST['vehicle_id'];
    $last_maintenance_date = $_POST['last_maintenance_date'];
    $next_maintenance_date = $_POST['next_maintenance_date'];

    // Insert or update maintenance schedule for the vehicle in the database
    $sql = "INSERT INTO Maintenance (VehicleID, LastMaintenanceDate, NextMaintenanceDate) VALUES ('$vehicle_id', '$last_maintenance_date', '$next_maintenance_date')
            ON DUPLICATE KEY UPDATE LastMaintenanceDate = '$last_maintenance_date', NextMaintenanceDate = '$next_maintenance_date'";
    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Maintenance schedule updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
    <style>
        /* Sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background color */
            padding-top: 50px;
        }

        .sidebar h2 {
            color: #fff; /* White text color */
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            color: #fff; /* White text color */
        }

        .sidebar a:hover {
            background-color: #495057; /* Darker background color on hover */
        }

        /* Content area styles */
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .icon {
            font-size: 24px;
            margin-right: 10px;
        }

        /* Custom styles */
        h2 {
            color: #343a40; /* Dark text color */
        }

        h4 {
            color: #007bff; /* Blue text color */
        }

        p {
            color: #6c757d; /* Gray text color */
        }

        /* Chart container */
        .chart-container {
            width: 100%;
            max-width: 600px; /* Adjust as needed */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-center mb-4">Admin Dashboard</h2>
        <a href="admindashboard.php">Dashboard</a>  
        <a href="adminviewdriver.php">Manage Drivers</a>
        <a href="adminviewdriver.php">View Drivers</a>
        <a href="#">Manage Fleet</a>
        <a href="adminmanagepas.php">Manage Passengers</a>
        <a href="maintenance_schedule.php">Maintainace schedule</a>
        <a href="#">Reports</a>
        <a href="#">Payments</a>
        <a href="#">Bookings</a>
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php">Logout</a>
    </div>
<!-- HTML form to input maintenance schedule details -->
<div class="container">
    <h2>Add/Update Maintenance Schedule</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="vehicle_id">Vehicle ID:</label>
            <input type="text" class="form-control" id="vehicle_id" name="vehicle_id" required>
        </div>
        <div class="form-group">
            <label for="last_maintenance_date">Last Maintenance Date:</label>
            <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date" required>
        </div>
        <div class="form-group">
            <label for="next_maintenance_date">Next Maintenance Date:</label>
            <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    