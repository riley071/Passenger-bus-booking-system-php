<?php
// Include database connection
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve password and user type for the given username
    $sql = "SELECT Password, UserType FROM Admin WHERE Username = ? UNION SELECT Password, UserType FROM Passenger WHERE Username = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);

    // Execute the statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($hashed_password, $user_type);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session
            session_start(); // Start session
            if ($user_type === 'admin') {
                $_SESSION['admin_username'] = $username; // Store admin username in session
                header("Location: admin/admindashboard.php"); // Redirect to admin dashboard
            } else {
                $_SESSION['passenger_username'] = $username; // Store passenger username in session
                header("Location: dashboard.php"); // Redirect to passenger dashboard
            }
            exit(); // Stop further execution
        } else {
            // Invalid password
            $login_error = "Invalid password. Please try again.";
        }
    } else {
        // Username not found
        $login_error = "Username not found.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- You can add custom styles here -->
   </head>
<body>
    <div class="container">
        <h2 class="mt-5 text-center">Passenger/Admin Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="passengerreg.php">Register here</a>.</p>
            <a href="index.php">Home</a>
        </div>
    </div>
</body>
</html>
