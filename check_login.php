<?php
// Establish database connection
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}

// Retrieve username and password from the form
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

// Prepare and execute query
$query = "SELECT * FROM users WHERE username = :username AND password = :password";
$statement = $pdo->prepare($query);
$statement->execute(array(':username' => $username, ':password' => $password));

// Check if a row is returned
if ($statement->rowCount() > 0) {
    // Redirect to student services page
    header('Location: stservices.html');
    exit;
} else {
    // Redirect back to login page with error message
    header('Location: login.html?error=1');
    exit;
}
?>
