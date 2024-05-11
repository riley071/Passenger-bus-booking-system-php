<?php
// Start session

session_start();


// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/style.css"> <!-- Your custom styles -->
    </head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Passenger Dashboard</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="passprofile.php"><i class="fas fa-user"></i> View/Edit Profile</a>
        <a href="tripview.php"><i class="fas fa-bus"></i> Book Ticket</a>
        <a href="view_bookings.php"><i class="fas fa-book-open"></i>  View Tickets </a>
       
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="content">
    <h2>Bus Hiring</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-bus"></i> Hire Bus</h4>
        </div>
        <div class="card-body">
        <form action="process_hiring.php" method="POST">
    <div class="form-group row">
        <label for="start_date" class="col-sm-2 col-form-label">Start Date:</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="end_date" class="col-sm-2 col-form-label">End Date:</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="total_distance" class="col-sm-2 col-form-label">Total Distance (in km):</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="total_distance" name="total_distance" required>
        </div>
    </div>
    <!-- You can add more fields as needed -->
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Hire Bus</button>
        </div>
    </div>
</form>

 </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

