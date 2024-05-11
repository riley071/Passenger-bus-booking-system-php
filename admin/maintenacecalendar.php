<?php
// Start the session
include 'db_connect.php';
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
       <link rel="stylesheet" href="css/style.css">
    <!-- Custom CSS -->
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f0f0f0;
        }
        .active {
            background-color: lightblue;
        }
        /* Styles for the calendar */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .day {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
        }
        .day.active {
            background-color: lightblue;
        }

        /* Additional styles for better appearance */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        
        .day {
            background-color: #fff;
        }
        .day.active {
            background-color: lightblue;
        }
        .calendar td {
    width: 100px; /* Adjust width as needed */
    height: 100px; /* Adjust height as needed */
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
}

.calendar .active {
    background-color: #ffc107; /* Yellow background color for maintenance days */
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
       
        <a href="add_vehicle.php"><i class="fas fa-truck icon"></i>Add Fleet</a>
        <a href="view_vehicle.php"><i class="fas fa-pencil-alt icon"></i> View Fleet</a>
        <a href="addfuel.php"><i class="fas fa-gas-pump icon"></i>Record Fuel Fill-Up</a> 
        <a href="view_fuel_refill.php"><i class="fas fa-list icon"></i>View Fuel Fill-Up</a>
        <a href="adminmanagepas.php"><i class="fas fa-users icon"></i>Manage Passengers</a>
        <hr>
        <a href="add_booking"><i class="fas fa-bus icon"></i>Add Booking</a>
        <a href="adminviewbook.php"><i class="fas fa-book icon"></i>Bookings</a>
        <a href="reports.php"><i class="fas fa-chart-bar icon"></i>Reports</a>
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
    </div>

    <div class="content">
        <div class="container mt-4">
            <h2>Maintenance Schedule Calendar</h2>

            <div class="calendar">
                <?php
                // Query to fetch maintenance schedule dates
                $sql = "SELECT DueDate FROM maintenance_schedule";
                $result = $conn->query($sql);

                // Store maintenance schedule dates in an array
                $maintenanceDates = [];
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $maintenanceDates[] = date("j", strtotime($row["DueDate"]));
                    }
                }

                // Close the database connection
                $conn->close();

                // Get the current month and year
                $currentMonth = date("n");
                $currentYear = date("Y");

                // Calculate the number of days in the current month
                $numDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

                // Get the first day of the month
                $firstDay = date("N", strtotime("{$currentYear}-{$currentMonth}-01"));

                // Create a table for the calendar
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Mon</th>';
                echo '<th>Tue</th>';
                echo '<th>Wed</th>';
                echo '<th>Thu</th>';
                echo '<th>Fri</th>';
                echo '<th>Sat</th>';
                echo '<th>Sun</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Start the first row
                echo '<tr>';

                // Output blank cells for days before the first day of the month
                for ($i = 1; $i < $firstDay; $i++) {
                    echo '<td></td>';
                }

                // Loop through each day of the month
                for ($day = 1; $day <= $numDays; $day++) {
                    // Check if the current day has maintenance scheduled
                    $isMaintenance = in_array($day, $maintenanceDates);

                    // Add a CSS class to highlight the day if maintenance is scheduled
                    $class = $isMaintenance ? 'active' : '';

                    // Output the day in a table cell
                    echo "<td class='{$class}'>{$day}</td>";

                    // If it's Sunday (day 7), end the current row and start a new one
                    if (($firstDay + $day - 1) % 7 == 0) {
                        echo '</tr><tr>';
                    }
                }

                // End the last row
                echo '</tr>';

                // Close the table
                echo '</tbody>';
                echo '</table>';
                ?>
            </div>
        </div>
    </div>    </div>
</body>
</html>
