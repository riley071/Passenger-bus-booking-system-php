<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <style>
        /* Improved sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background color */
            padding-top: 50px;
            overflow-y: auto; /* Add scrollbar for overflow */
        }

        .sidebar h2 {
            color: #fff; /* White text color */
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            color: #d1d8e0; /* Light text color */
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057; /* Darker background color on hover */
            color: #fff; /* White text color on hover */
        }

        .sidebar hr {
            border-top: 1px solid #6c757d; /* Gray border */
            margin: 20px 0;
        }

        /* Content area styles */
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        h2 {
            color: #343a40; /* Dark text color */
            margin-top: 0;
        }

        h4 {
            color: #007bff; /* Blue text color */
            margin-top: 0;
        }

        p {
            color: #6c757d; /* Gray text color */
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Passenger Dashboard</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="passprofile.php"><i class="fas fa-user"></i> View/Edit Profile</a>
        <a href="tripview.php"><i class="fas fa-bus"></i> Book Ticket</a>
        <a href="view_bookings.php"><i class="fas fa-book-open"></i>  View Tickets </a>
        <a href="bushiring.php"><i class="fas fa-book-open"></i>  Bus hire </a>
        
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
 <!-- Content area -->
 <div class="content">
    <!-- Content area -->
    <div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-book"></i> My Bookings</h4>
    </div>
    <div class="card-body">

        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Trip ID</th>
                    <th>Booking Date</th>
                    <th>Number of Seats</th>
                    <th>Total Fare</th>
                    <th>Payment Method</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();

                // Check if passenger is logged in
                if (!isset($_SESSION['passenger_username'])) {
                    header("Location: login.php"); // Redirect to login page if not logged in
                    exit;
                }

                // Include database connection
                include 'db_connect.php';

                // Retrieve passenger ID from the database based on the username stored in the session
                $passenger_username = $_SESSION['passenger_username'];
                $sql_passenger_id = "SELECT PassengerID FROM passenger WHERE username = '$passenger_username'";
                $result_passenger_id = $conn->query($sql_passenger_id);

                if ($result_passenger_id && $result_passenger_id->num_rows > 0) {
                    $row_passenger_id = $result_passenger_id->fetch_assoc();
                    $passenger_id = $row_passenger_id['PassengerID'];

                    // Query to retrieve bookings for the logged-in passenger
                    $sql_bookings = "SELECT * FROM bookings WHERE PassengerID = $passenger_id";
                    $result_bookings = $conn->query($sql_bookings);

                    if ($result_bookings && $result_bookings->num_rows > 0) {
                        // Output data of each row
                        while($row = $result_bookings->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row["BookingID"]."</td>";
                            echo "<td>".$row["TripID"]."</td>";
                            echo "<td>".$row["BookingDate"]."</td>";
                            echo "<td>".$row["NumSeatsBooked"]."</td>";
                            echo "<td>".$row["TotalFare"]."</td>";
                            echo "<td>".$row["PaymentMethod"]."</td>";
                            echo "<td><a href='print_receipt.php?booking_id=".$row['BookingID']."'>Print Receipt</a></td>";
                     
                            echo "</tr>";
                              }
                    } else {
                        echo "<tr><td colspan='6'>No bookings found.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Passenger ID not found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>

</body>
</html>
