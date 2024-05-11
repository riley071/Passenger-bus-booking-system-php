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

// Check if PassengerID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $passenger_id = $_GET['id'];

    // Fetch passenger details from the database based on PassengerID
    $sql = "SELECT * FROM Passenger WHERE PassengerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $passenger_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $passenger = $result->fetch_assoc();
    } else {
        echo "Passenger not found.";
        exit();
    }

    // Close statement
    $stmt->close();
} else {
    echo "Passenger ID not provided.";
    exit();
}

// Handle form submission for updating passenger details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update passenger details in the database
    $sql = "UPDATE Passenger SET Username=?, Name=?, Age=?, Email=?, Phone=? WHERE PassengerID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $username, $name, $age, $email, $phone, $passenger_id);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        echo "Passenger details updated successfully.";
    } else {
        echo "Failed to update passenger details.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Passengers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
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
        <a href="view_vehicle.php"><i class="fas fa-pencil-alt icon"></i> View Fleet</a>
          <a href="addfuel.php"><i class="fas fa-gas-pump icon"></i>Record Fuel Fill-Up</a>
          <a href="view_fuel_refill.php"><i class="fas fa-list icon"></i>View Fuel Fill-Up</a>  <div class="dropdown">
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
    <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center my-4">Update Passenger Details</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $passenger_id; ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $passenger['Username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $passenger['Name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo $passenger['Age']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $passenger['Email']; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $passenger['Phone']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
       
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <!-- Chart.js -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
