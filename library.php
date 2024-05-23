<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library reservation</title>
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
        <h1>Library Reservation</h1>
        <hr class="separator">

        <form action="reservation-confirmation.html" method="post" onsubmit="return saveReservation()">
            <label for="hour">Choose Hour:</label>
            <input type="time" id="hour" name="hour" required>

            <label for="date">Choose Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="row">Select Row:</label>
            <input type="number" id="row" name="row" min="1" required>

            <label for="column">Select Column:</label>
            <input type="number" id="column" name="column" min="1" required>

            <div class="button-container">
                <button type="submit">Submit</button>
                <button type="button" onclick="goBack()">Back</button>
            </div>
        </form>
    </div>

    <script>
        function saveReservation() {
    
            alert('Reserved successfully!');
           
            window.location.href = 'myRe.php';
            return false; 
        }

        function goBack() {
            window.location.href = 'stservices.html';
        }
    </script>

</body>
</html>