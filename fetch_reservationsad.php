<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'swe417');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if cancel request is sent
if (isset($_GET['cancelId'])) {
    // Retrieve reservation id to cancel
    $cancelId = $_GET['cancelId'];

    // SQL to delete reservation based on reservation id
    $deleteSql = "DELETE FROM reservations WHERE id = $cancelId";

    // Execute deletion query
    if (mysqli_query($conn, $deleteSql)) {
        echo "Reservation cancelled successfully";
    } else {
        echo "Error cancelling reservation: " . mysqli_error($conn);
    }
}

// Retrieve userId from query parameter
$userId = $_GET['userId'];

// Fetch reservations data for the specific user
$sql = "SELECT r.*, a.availability, f.Type
        FROM reservations r
        INNER JOIN availability a ON r.availabilityid = a.AvailabilityID
        INNER JOIN facility f ON a.FacilityID = f.id
        WHERE r.userId = $userId"; // Add condition to filter reservations by userId
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output reservation items
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="reservation-item">';
        echo '<p><strong>Reservation ' . $row['id'] . '</strong></p>';
        echo '<p><strong>Type:</strong> ' . $row['Type'] . '</p>';
        echo '<p><strong>Time:</strong> ' . date('H:i', strtotime($row['availability'])) . '</p>';
        echo '<p><strong>Date:</strong> ' . date('Y-m-d', strtotime($row['availability'])) . '</p>';
        echo '<p><strong>Reserved Entity:</strong> ' . $row['entity'] . '</p>';
        echo '<button onclick="cancelReservation(' . $row['id'] . ')">Cancel</button>'; // Add onclick event for cancel
        echo '</div>';
    }
} else {
    echo '<p>No reservations yet.</p>';
}

// Close connection
mysqli_close($conn);
?>
