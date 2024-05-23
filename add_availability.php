<?php
// Connect to database
$conn = mysqli_connect('localhost', 'root', '', 'swe417');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling addition of new facility
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $availability = $_POST['availability'];
    $parameter = $_POST['parameter'];

    // Insert new facility into the database
    $insertSql = "INSERT INTO availability (Availability, FacilityID) VALUES ('$availability', '$parameter')";

    if (mysqli_query($conn, $insertSql)) {
        echo "Availability added successfully";
    } else {
        echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "No form submission detected";
}

// Close connection
mysqli_close($conn);
?>
