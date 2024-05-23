<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Page</title>
    <link rel="stylesheet" href="graduation.css">
</head>
<body>

    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="home.html">Home</a>
            <a href="about.html">About Us</a>
        </nav>
    </header>

    <div class="login-container">
        <h2>Student System</h2>
        <form id="loginForm" action="#" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <a href="FPass1.html" class="forgot-password"> Forgot Password</a>
    
    </div>

    <?php
    // PHP code starts here
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Establish database connection

        // Create connection
        $conn = mysqli_connect('localhost', 'root', '', 'swe417');

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve username and password from the form
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Prepare and execute query
        $query = "SELECT id FROM users WHERE username = ? AND password = ? AND role = 'student'";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, 'ss', $username, $password);
        mysqli_stmt_execute($statement);
        
        // Get the result
        $result = mysqli_stmt_get_result($statement);

        // Check if a row is returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userId = $row['id'];
            echo "<script>localStorage.setItem('userid', $userId);</script>";
            mysqli_stmt_close($statement);
        mysqli_close($conn);

        // Redirect to student services page with user ID in URL parameters
        echo "<script>window.location.href = 'stservices.html?userId=' + $userId;</script>";
        exit;
    } else {
        // Show alert for incorrect password
        echo "<script>alert('Incorrect username or password');</script>";
    }

    // Close statement and connection
    mysqli_stmt_close($statement);
    mysqli_close($conn);
}

    ?>
</body>
</html>
