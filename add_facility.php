<?php
// Connect to database
$conn = mysqli_connect('localhost', 'root', '', 'swe417');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling addition of new facility
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNo = $_POST['roomNo'];
    $description = $_POST['description'];
    $building = $_POST['building'];
    $noSeats = $_POST['noSeats'];
    $type = $_POST['type'];

    // Insert new facility into the database
    $insertSql = "INSERT INTO facility (RoomNo, Description, Building, Noseats, Type) VALUES ('$roomNo', '$description', '$building', '$noSeats', '$type')";

    if (mysqli_query($conn, $insertSql)) {
        echo "Facility added successfully";
    } else {
        echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "No form submission detected";
}

// Close connection
mysqli_close($conn);
?>
