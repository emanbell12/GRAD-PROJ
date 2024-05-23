<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <link rel="stylesheet" href="graduation.css">
    
    <style>
        /* CSS for the modal */
        .modal {
            display: none; /* Initially hide the modal */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
            position: relative;
        }
        
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="reservations.html">Reservations</a>
            <a href="announcements.html">Announcements</a>
           <a href="facilities.php">Facilities</a>
           <a href="members.php">Members</a>
           <a href="logout.html" target="_blank">Log Out</a>
        </nav>
    </header>

    <div class="reservations-container">
        <h1>User's Reservations</h1>
        <hr class="separator">
        <div id="reservations-list">
            <?php
            // Establish database connection
            $conn = mysqli_connect('localhost', 'root', '', 'swe417');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
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
           
        </div> <button class="member-card" onclick="addReservation()"> Add Reservation
        </button>
        
    </div>
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Add New Reservation</h2>
            <form id="addMemberForm" action="add_member.php" method="POST">
                <label for="memberName">Name:</label>
                <input type="text" id="memberName" name="memberName" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <label for="position">Position:</label>
                <select id="position" name="position" required>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                </select><br><br>
                <label for="joinDate">Join Date:</label>
                <input type="date" id="joinDate" name="joinDate" required><br><br>
                <button type="submit">Add Member</button>
            </form>
        </div>
    </div>
</body><script>
    function addReservation() {
    // Get the userId from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userId');
    const userRole = urlParams.get('role');
    // Set the userId to localStorage
    localStorage.setItem('userid', userId);

    if(userRole==="Student")
    window.location.href = 'stservices.html';
    else window.location.href = 'faservices.html';
}
        function cancelReservation(reservationId) {
            if (confirm('Are you sure you want to cancel this reservation?')) {
                fetch(`fetch_reservationsad.php?cancelId=${reservationId}`, {
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

        // Function to fetch reservations using userId
        function fetchReservations(userId, reservationsList) {
            fetch("fetch_reservationsad.php?userId=" + userId)
                .then(response => response.text())
                .then(data => {
                    reservationsList.innerHTML = data; // Populate reservations list
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            var userId = urlParams.get("userId");
            var reservationsList = document.getElementById("reservations-list");
            fetchReservations(userId, reservationsList); // Call function to fetch reservations
        });
        function showAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
        function hideModal() {
            document.getElementById('addModal').style.display = 'none';

        }
    </script>
</html>
