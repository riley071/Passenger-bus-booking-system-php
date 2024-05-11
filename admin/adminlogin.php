<?php
// Include database connection
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve password for the given username
    $sql = "SELECT Password FROM Admin WHERE Username = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    // Execute the statement
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($hashed_password);

        // Fetch the result
        if ($stmt->fetch()) {
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start session
                session_start(); // Start session
                $_SESSION['admin_username'] = $username; // Store username in session
                header("Location: admindashboard.php"); // Redirect to admin dashboard
                exit(); // Stop further execution
            } else {
                // Invalid username or password
                $login_error = "Invalid username or password. Please try again.";
            }
        } else {
            // Username not found
            $login_error = "Username not found.";
        }
    } else {
        // SQL execution error
        $login_error = "Error executing SQL statement.";
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 100px;
        }
        .login-form {
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 0 auto;
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Admin Login</h2>
            <?php if (isset($login_error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $login_error; ?>
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

