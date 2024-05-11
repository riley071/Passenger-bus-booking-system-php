<?php
// Start session
session_start();

// Check if passenger is logged in
if (!isset($_SESSION['passenger_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
include 'db_connect.php';

// Define variables for error message
$update_success = false;
$update_error = "";

// Get passenger information from session or database
$passenger_username = $_SESSION['passenger_username'];
$sql = "SELECT * FROM Passenger WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $passenger_username);
$stmt->execute();
$result = $stmt->get_result();
$passenger = $result->fetch_assoc();
$stmt->close();

// If form is submitted for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update passenger information in the database
    $sql = "UPDATE Passenger SET Name=?, Age=?, Email=?, Phone=? WHERE PassengerID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $name, $age, $email, $phone, $passenger['PassengerID']);
    if ($stmt->execute()) {
        $update_success = true; // Set flag for successful update
    } else {
        $update_error = "Error updating profile. Please try again."; // Set error message
    }
    $stmt->close();

    // Refresh passenger data from the database
    $sql = "SELECT * FROM Passenger WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $passenger_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $passenger = $result->fetch_assoc();
    $stmt->close();
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
        <a href="bushiring.php"><i class="fas fa-book-open"></i>  Bus hire </a>
       
        <!-- Add more sidebar links as needed -->
        <hr>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content area -->
    <div class="content">
        <h2>My Profile</h2>
        <?php if ($update_success) : ?>
            <div class="alert alert-success" role="alert">
                Profile updated successfully.
            </div>
        <?php endif; ?>
        <?php if (!empty($update_error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $update_error; ?>
            </div>
        <?php endif; ?>
        <div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-user"></i> View/Edit Profile</h4>
    </div>
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $passenger['Username']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $passenger['Name']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="age" class="col-sm-2 col-form-label">Age:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo $passenger['Age']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $passenger['Email']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $passenger['Phone']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
