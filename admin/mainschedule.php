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

// Initialize message variable
$message = "";

// Fetch vehicles from the database
$sql = "SELECT * FROM vehicle";
$result = $conn->query($sql);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicleID = $_POST['vehicleID'];
    $maintenanceType = $_POST['maintenanceType'];
    $dueDate = $_POST['dueDate'];

    // Insert new maintenance schedule into database
    $sql = "INSERT INTO maintenance_schedule (VehicleID, MaintenanceType, DueDate) VALUES ('$vehicleID', '$maintenanceType', '$dueDate')";
    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        $message = "New maintenance schedule added successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
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
       
        <a href="add_vehicle.php"><i class="fas fa-truck icon"></i>Add Fleet</a>
        <a href="view_vehcile.php"><i class="fas fa-pencil-alt icon"></i> View Fleet</a>
          <a href="addfuel.php"><i class="fas fa-gas-pump icon"></i>Record Fuel Fill-Up</a>
          <a href="view_fuel_refill.php"><i class="fas fa-list icon"></i>View Fuel Fill-Up</a>  
        <a href="adminmanagepas.php"><i class="fas fa-users icon"></i>Manage Passengers</a>
        <hr>
        <a href="add_booking.php"><i class="fas fa-bus icon"></i>Add Booking</a>
        <a href="adminviewbook.php"><i class="fas fa-book icon"></i>Bookings</a>
        <a href="reports.php"><i class="fas fa-chart-bar icon"></i>Reports</a>
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
    </div>
    <!-- HTML form to input maintenance schedule details -->
    <div class="content">
    <div class="container mt-4">
    <div class="card mt-4">
    <div class="card-header">
        <h2>Add Maintenance Schedule</h2>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="vehicleID">Select Vehicle:</label>
                <select class="form-control" id="vehicleID" name="vehicleID" required>
                    <option value="">Select Vehicle</option>
                    <?php
                    // Loop through vehicles and create options
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['VehicleID'] . "'>" . $row['Model'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="maintenanceType">Maintenance Type:</label>
                <input type="text" class="form-control" id="maintenanceType" name="maintenanceType" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Maintenance Schedule</button>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
