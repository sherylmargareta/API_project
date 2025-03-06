<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle signup form submission
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform database insertion here, using the hashed password
    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful signup
        // header("Location: login.php");
        echo '<script>alert("Informasi user berhasil dibuat!");window.location="login.php";</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>DebtPaying - Sign Up</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Sign Up</h2>
                <form action="signup.php" method="post">
                    <!-- Signup form fields go here -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
                <div class="text-center mt-3">
                    <p>Sudah punya akun? <strong><a href="login.php">Login</a></strong></p>
            </div>
        </div>
    </div>
</body>
</html>
