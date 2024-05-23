<?php
// Connect to your database
$conn = mysqli_connect('localhost', 'root', '', 'swe417');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling addition of new member
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $reciever = $_POST['reciever'];

    // Insert new member into the database
    $insertSql = "INSERT INTO announcements (Receivers, Title, Content) VALUES ('$reciever', '$title', '$content')";

    if (mysqli_query($conn, $insertSql)) {
        echo "New announcement added successfully";
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

