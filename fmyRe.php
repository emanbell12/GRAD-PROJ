<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <link rel="stylesheet" href="graduation.css">
    <script>
    function cancelReservation(reservationId) {
        if (confirm('Are you sure you want to cancel this reservation?')) {
            fetch(`fetch_reservations.php?cancelId=${reservationId}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(data => {
                // Refresh reservations list after cancellation
                var userId = localStorage.getItem("userid");
                var reservationsList = document.getElementById("reservations-list");
                fetchReservations(userId, reservationsList);
            })
            .catch(error => console.error('Error cancelling reservation:', error));
        }
    }
</script>

</head>
<body>
    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="home.html">Home</a>
            <a href="faculty_announcements.php">Announcements</a>
            <a href="about.html">About Us</a>
            <a href="faservices.html">Faculty Services</a>
            <a href="logout.html" >Log Out</a>
        </nav>
    </header>

    <div class="reservations-container">
        <h1>My Reservations</h1>
        <hr class="separator">
        <div id="reservations-list">
    <?php
    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', '', 'swe417');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve userId from localStorage using JavaScript
    echo '<script>';
    echo 'var userId = localStorage.getItem("userid");';
    echo '</script>';

    // Fetch reservations data for the specific user
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '  var reservationsList = document.getElementById("reservations-list");';
    echo '  fetchReservations(userId, reservationsList);'; // Call function to fetch reservations
    echo '});';
    echo '</script>';

    // Function to fetch reservations using userId
    echo '<script>';
    echo 'function fetchReservations(userId, reservationsList) {';
    echo '  fetch("fetch_reservations.php?userId=" + userId)' ; // Pass userId as query parameter
    echo '    .then(response => response.text())';
    echo '    .then(data => {';
    echo '      reservationsList.innerHTML = data;'; // Populate reservations list
    echo '    });';
    echo '}';
    echo '</script>';
    ?>
</div>

    </div>
</body>
</html>
