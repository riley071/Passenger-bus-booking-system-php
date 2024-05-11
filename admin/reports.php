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
   
    <link rel="stylesheet" href="css/style.css">
    <!-- Custom CSS -->
    <style>
        canvas {
    display: block;
    margin: 0 auto;
    max-width: 100%;
}
    </style>
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
           <!-- Analytics Section -->

           <div class="container mt-4">
    <h2 class="text-center">Reports and Analytics</h2>
    
    <!-- Booking Reports -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0">Booking Reports</h4>
        </div>
        <div class="card-body">
            <?php
            // Include database connection
            include 'db_connect.php';

            // Fetch booking data from the database
            $sql_booking_reports = "SELECT * FROM bookings";
            $result_booking_reports = $conn->query($sql_booking_reports);

            if ($result_booking_reports->num_rows > 0) {
                // Output data of each row
                echo "<table class='table table-hover'>";
                echo "<thead class='thead-light'>";
                echo "<tr>";
                echo "<th>Booking ID</th>";
                echo "<th>Passenger ID</th>";
                echo "<th>Trip ID</th>";
                echo "<th>Booking Date</th>";
                echo "<th>Number of Seats Booked</th>";
                echo "<th>Total Fare</th>";
                echo "<th>Payment Method</th>";
                echo "<th>Discount ID</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result_booking_reports->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["BookingID"] . "</td>";
                    echo "<td>" . $row["PassengerID"] . "</td>";
                    echo "<td>" . $row["TripID"] . "</td>";
                    echo "<td>" . $row["BookingDate"] . "</td>";
                    echo "<td>" . $row["NumSeatsBooked"] . "</td>";
                    echo "<td>" . $row["TotalFare"] . "</td>";
                    echo "<td>" . $row["PaymentMethod"] . "</td>";
                    echo "<td>" . $row["DiscountID"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No booking records found";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
        <!-- Add Export Button -->
        <div class="card-footer">
            <button id="export-booking-pdf-button" class="btn btn-primary">Export Booking Report to PDF</button>
            <button id="export-booking-csv-button" class="btn btn-success">Export Booking Report to CSV</button>
        </div>
    </div>
    
    <!-- Fleet Reports -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0">Fleet Reports</h4>
        </div>
        <div class="card-body">
            <?php
            // Include database connection
            include 'db_connect.php';

            // Fetch fleet data from the database
            $sql_fleet_reports = "SELECT * FROM vehicle";
            $result_fleet_reports = $conn->query($sql_fleet_reports);

            if ($result_fleet_reports->num_rows > 0) {
                // Output data of each row
                echo "<table class='table table-hover'>";
                echo "<thead class='thead-light'>";
                echo "<tr>";
                echo "<th>Vehicle ID</th>";
                echo "<th>Vehicle Number</th>";
                echo "<th>Model</th>";
                echo "<th>Year</th>";
                echo "<th>Mileage</th>";
                echo "<th>Last Service Date</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result_fleet_reports->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["VehicleID"] . "</td>";
                    echo "<td>" . $row["VehicleNumber"] . "</td>";
                    echo "<td>" . $row["Model"] . "</td>";
                    echo "<td>" . $row["Year"] . "</td>";
                    echo "<td>" . $row["Mileage"] . "</td>";
                    echo "<td>" . $row["LastServiceDate"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No fleet records found";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
        <!-- Add Export Button -->
        <div class="card-footer">
            <button id="export-fleet-pdf-button" class="btn btn-primary">Export Fleet Report to PDF</button>
            <button id="export-fleet-csv-button" class="btn btn-success">Export Fleet Report to CSV</button>
        </div>
    </div>
</div>
<!-- Add this script at the end of your HTML body -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

<script>
    document.getElementById('export-booking-pdf-button').addEventListener('click', function() {
        exportToPDF('booking-report', 'booking-report.pdf');
    });

    document.getElementById('export-booking-csv-button').addEventListener('click', function() {
        // Add functionality to export to CSV here
    });

    document.getElementById('export-fleet-pdf-button').addEventListener('click', function() {
        exportToPDF('fleet-report', 'fleet-report.pdf');
    });

    document.getElementById('export-fleet-csv-button').addEventListener('click', function() {
        // Add functionality to export to CSV here
    });

    function exportToPDF(elementId, fileName) {
        domtoimage.toPng(document.getElementById(elementId))
            .then(function(blob) {
                var pdf = new jsPDF();
                pdf.addImage(blob, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
                pdf.save(fileName);
            });
    }
</script>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

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
