<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop reservation </title>
    <link rel="stylesheet" href="graduation.css">
</head>
<body>
    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="#">Announcements</a>
            <a href="myRe.php">My Reservations</a>
            <a href="faservices.html">Faculty Services</a>
            <a href="about.html">About Us</a>
            <a href="logout.html" >Log Out</a>
        </nav>
    </header>
     
    <div class="lab-container">
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'swe417');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM facility WHERE Type = 'Workshop'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["ID"];
            echo '<div class="lab1">';
            echo "<h1>" . "Workshop: " . $row["RoomNo"] . "</h1>";
            echo "<p>" . "Building: " . $row["Building"] . "<br>" . "</p>";
            echo "<p>" . "Description: " . $row["Description"] . "<br>" .  "</p>";
            echo '<form onsubmit="redirectToConfirmationPage(\'workshop2.php\', \'' . $id . '\'); return false;">';
            echo '<button type="submit">Reserve</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "No facilities of type 'lab' found.";
    }

    $conn->close();
    ?>
</div>


    <script>
        function redirectToConfirmationPage(page, id) {
            window.location.href = page + '?ID=' + id;
        }
    </script>
</body>
</html>
