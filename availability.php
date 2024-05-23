<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Facilities</title>
    <link rel="stylesheet" href="graduation.css">
    <style>
        body { 
            background: none;
            background-color: #C8AE81;
            overflow-y: auto;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Facility List Styles */
        .facility-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}



        .facility-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .facility-card:hover {
            transform: translateY(-5px);
        }

        .facility-card h3 {
            margin-top: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .facility-card p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .modal h2 {
            margin-top: 0;
        }

        .modal button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: maroon;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: rgba(128, 0, 0, 0.795);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>
<body >
    <header>
        <img src="dash.images/logo1.png" alt="Logo">
        <nav>
            <a href="reservations.php">Reservations</a>
            <a href="announcements.php">Announcements</a>
            <a href="members.php">Members</a>
            <a href="logout.html" target="_blank">Log Out</a>
        </nav>
    </header>

    <div class="container" >
        <h1>Manage Availabilities</h1>
        <hr class="separator">

        <!-- Facility List -->
        <div class="facility-list">
        <?php
            // Connect to your database
            $conn = mysqli_connect('localhost', 'root', '', 'swe417');

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Handling deletion of member
if (isset($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    
    // SQL query to delete member from the database
    $deleteSql = "DELETE FROM availability WHERE AvailabilityID = $deleteId";

    if (mysqli_query($conn, $deleteSql)) {
        echo "facility deleted successfully";
    } else {
        echo "Error deleting facility: " . mysqli_error($conn);
    }
}
$parameter = $_GET['parameter'];

$parameter = mysqli_real_escape_string($conn, $parameter);
            // Query to retrieve member information
            $sql = "SELECT 
            AvailabilityID,
            FacilityID,
            Availability
         FROM availability
         WHERE FacilityID = '$parameter'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output member cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="facility-card" onclick="showOptionsModal(' . $row['AvailabilityID'] . ', \'' . $row['FacilityID'] . '\', \'' . $row['Availability'] . '\')">';
                    echo '<h3>' . $row['Availability']  .'</h3>';
                    echo '<p>FacilityID: ' . $row['FacilityID'] . '<br>AvailabilityID: ' . $row['AvailabilityID'] .'</p>';
                    echo '</div>';
                }
            } else {
                echo "No Availabilities found";
            }

            // Close connection
            mysqli_close($conn);
            ?>
            <!-- Add new facility card -->
            <div class="facility-card" onclick="showAddModal()">
                <h3>Add New Availability</h3>
            </div>
        </div>
    </div>

    <!-- Edit/Delete Modal -->
    <div id="editDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2> Availability Actions</h2>
            <p>Please select an action for <span id="selectedMember"></span>:</p>
            <button onclick="deleteMember(document.getElementById('selectedMember').value)">Delete</button>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="hideModal()">&times;</span>
        <div class="return-arrow" onclick="hideModal()">&#8592;</div>
        <h2>Add New Availability</h2>
        <form id="addAvailabilityForm" action="add_availability.php" method="POST">
            <label for="availability">Availability:</label>
            <input type="datetime-local" id="availability" name="availability" required><br><br>
            <!-- Hidden input field for the parameter value -->
            <input type="hidden" id="parameter" name="parameter" value="<?php echo htmlspecialchars($_GET['parameter']); ?>">
            <button type="submit">Add Availability</button>
        </form>
    </div>
</div>


    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit Member</h2>
            <form id="editMemberForm">
                <label for="editMemberName">Name:</label>
                <input type="text" id="editMemberName" name="editMemberName" required><br><br>
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="editEmail" required><br><br>
                <label for="editPosition">Position:</label>
                <select id="editPosition" name="editPosition" required>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                </select><br><br>
                <label for="editJoinDate">Join Date:</label>
                <input type="date" id="editJoinDate" name="editJoinDate" required><br><br>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Function to show edit/delete modal
        function showOptionsModal(AvailabilityID,	
            FacilityID,	
            Availability,
        ) {
            document.getElementById('selectedMember').value = AvailabilityID;
            document.getElementById('selectedMember').textContent = AvailabilityID;
            document.getElementById('editDeleteModal').style.display = 'flex';
        }

        // Function to hide modal
        function hideModal() {
            document.getElementById('editDeleteModal').style.display = 'none';
            document.getElementById('addModal').style.display = 'none';
            document.getElementById('editModal').style.display = 'none';
        }

        // Function to show add modal
        function showAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
       

        // Function to delete member
        function deleteMember(memberId) {
        if (confirm('Are you sure you want to delete this availability?')) {
            // Send deletion request to server
            fetch(`availability.php?deleteId=${memberId}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(data => {
                
                // Reload the page or update member list as needed
                location.reload(); // Example: Reload the page after deletion
            })
            .catch(error => console.error('Error deleting member:', error));
        }
    }
    document.getElementById("viewAvailabilityButton").addEventListener("click", function() {
    // Get the value you want to pass as a parameter
    var parameterValue = document.getElementById('selectedMember').value;
    
    // Construct the URL with the parameter
    var url = "availability.php?parameter=" + encodeURIComponent(parameterValue);
    
    // Navigate to the new page
    window.location.href = url;
});

        // Function to handle form submission for adding member


        // Function to handle form submission for editing member
        document.getElementById('editMemberForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const editedMemberName = document.getElementById('editMemberName').value;
            const editedEmail = document.getElementById('editEmail').value;
            const editedPosition = document.getElementById('editPosition').value;
            const editedJoinDate = document.getElementById('editJoinDate').value;
            alert(`Member details edited successfully:\nName: ${editedMemberName}\nEmail: ${editedEmail}\nPosition: ${editedPosition}\nJoin Date: ${editedJoinDate}`);
            hideModal();
        });
    </script>
</body>
</html>