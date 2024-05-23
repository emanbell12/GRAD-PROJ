<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'swe417');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST['reservationId'];

    // Prepare SQL statement to delete the reservation
    $deleteSql = "DELETE FROM reservations WHERE id = $reservationId";

    // Execute the deletion query
    if (mysqli_query($conn, $deleteSql)) {
        echo "Reservation canceled successfully.";
    } else {
        echo "Error canceling reservation: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
