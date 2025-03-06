<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle login form submission
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve hashed password from the database based on the username
    $sql = "SELECT password FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Verify the password using password_verify
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            // // Password is correct, redirect to dashboard or perform other actions
            // header("Location: index.php");
            // echo "Login berhasil!";
            echo '<script>alert("Login berhasil!");window.location="home.html";</script>';
        } else {
            // Password is incorrect
            // echo "Username atau password salah";
            echo '<script>alert("Username atau password salah")</script>';
        }
    } else {
        // User not found
        // echo "Username atau password salah";
        echo '<script>alert("Username atau password salah")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>DebtPaying - Login</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Login</h2>
                <form action="login.php" method="post">
                    <!-- Login form fields go here -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Belum punya akun? <strong><a href="signup.php">Sign Up</a></strong></p>
            </div>
        </div>
    </div>
</body>
</html>
