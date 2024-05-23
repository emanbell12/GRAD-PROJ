<?php
// Connect to your database
$conn = mysqli_connect('localhost', 'root', '', 'swe417');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling addition of new member
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberName = $_POST['memberName'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $joinDate = $_POST['joinDate'];
    $password = $_POST['password'];

    // Insert new member into the database
    $insertSql = "INSERT INTO users (username, email, password, role, full_name, join_date) VALUES ('$memberName', '$email', '$password', '$position', '$memberName', '$joinDate')";

    if (mysqli_query($conn, $insertSql)) {
        echo "New member added successfully";
    } else {
        // Display error message
        echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
    }
} else {
    // If the request method is not POST, display a message indicating no form submission
    echo "No form submission detected";
}

// Close connection
mysqli_close($conn);
?>

