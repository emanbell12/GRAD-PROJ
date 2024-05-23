<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Reservation 2</title>
    <link rel="stylesheet" href="graduation.css">
</head>
<body>
    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="#">Announcements</a>
            <a href="myRe.php">My Reservations</a>
            <a href="stservices.html">Student Services</a>
            <a href="about.html">About Us</a>
            <a href="logout.html" >Log Out</a>

        </nav>
    </header>


    <div class="reservation-container">
        <h1>Facility Reservation</h1>
        <hr class="separator">
        <?php
    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', '', 'swe417');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $availabilityId = $_POST['date']; 
        $entity = $_POST['seat']; // Assuming 'entity' is the correct column name
        $userId = $_POST['userId'];

        // Check if the combination already exists
        $check_sql = "SELECT * FROM reservations WHERE availabilityid = ? AND entity = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $availabilityId, $entity);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo '<p style="color: red;">Error: This is reserved!</p>';
        } else {
            // If the combination doesn't exist, proceed with insertion
            $sql = "INSERT INTO reservations (userid, availabilityid, entity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $userId, $availabilityId, $entity);
            
            if ($stmt->execute() === TRUE) {
                echo '<p style="color: green;">Reservation successful!</p>';
            } else {
                echo '<p style="color: red;">Error: ' . $conn->error . '</p>';
            }
            $stmt->close();
        }
        $check_stmt->close();
    }

    mysqli_close($conn);
?>

        <form action="#" method="post">
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'swe417');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_GET['ID'];
    $currentDateTime = date('Y-m-d H:i:s');

    // Query to select dates and times greater than or equal to the current date and time
    $sql = "SELECT * FROM availability WHERE FacilityID = $id AND Availability >= '$currentDateTime'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    echo '<h4>*Note: Reservations are made per hour, ex: 8:00 to 8:55 </h4>';
    echo '<label for="date">Choose Date and Hour:</label>';
    echo '<select id="date" name="date" required>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['AvailabilityID'] . '">' . $row['Availability'] . '</option>';
    }
    echo '</select>';

    $sql = "SELECT Noseats FROM facility WHERE ID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $num_seats = $row['Noseats'];

    echo '<label for="seat">Select Seat:</label>';
    echo '<select id="seat" name="seat" required>';
    for ($i = 1; $i <= $num_seats; $i++) {
        echo '<option value="' . $i . '">' . $i . '</option>';
    }
    echo '</select>';

    mysqli_close($conn);
    ?>

    <input type="hidden" name="userId" id="userId">

    <div class="button-container" id="1">
        <button type="submit">Submit</button>
        <button type="button" onclick="goBack()">Back</button>
    </div>
</form>

<script>
document.getElementById('userId').value = localStorage.getItem('userid');
</script>


    </div>

    <script>
   

    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
