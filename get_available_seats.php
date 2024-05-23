<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'swe417');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set in the GET request
if(isset($_GET['id'])) {
    $availabilityId = $_GET['id'];

    // Query to get the available seats for the selected availability ID
    $sql = "SELECT COUNT(*) AS available_seats FROM reservations WHERE AvailabilityID = $availabilityId";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $availableSeats = $row['available_seats'];

        // Return the available seat count in JSON format
        echo json_encode($availableSeats);
    } else {
        // If there's an error in the query, return 0 seats available
        echo json_encode(0);
    }
} else {
    // If the availability ID is not provided in the request, return 0 seats available
    echo json_encode(0);
}

// Close database connection
mysqli_close($conn);
?>
