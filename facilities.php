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
    margin-top: 10px;
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
            <a href="announcements.php">Announcements</a>
            <a href="members.php">Members</a>
            <a href="logout.html" target="_blank">Log Out</a>
        </nav>
    </header>

    <div class="container" >
        <h1>Manage Facilities</h1>
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
    $deleteSql = "DELETE FROM facility WHERE id = $deleteId";

    if (mysqli_query($conn, $deleteSql)) {
        echo "facility deleted successfully";
    } else {
        echo "Error deleting facility: " . mysqli_error($conn);
    }
}

            // Query to retrieve member information
            $sql = "SELECT 
            ID,	
            RoomNo,	
            Description,
            Building,	
            Noseats,	
            Type FROM facility";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output member cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="facility-card" onclick="showOptionsModal(' . $row['ID'] . ', \'' . $row['RoomNo'] . '\', \'' . $row['Description'] . '\', \'' . $row['Building'] . '\', \'' . $row['Noseats'] . '\')">';
                    echo '<h3>' . $row['Type'] .'' . $row['RoomNo'] .'</h3>';
                    echo '<p>ID: ' . $row['ID'] . '<br>Description: ' . $row['Description'] . '<br>Building: ' . $row['Building'] . '<br> Number of seats: ' . $row['Noseats'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No facilities found";
            }

            // Close connection
            mysqli_close($conn);
            ?>
            <!-- Add new facility card -->
            <div class="facility-card" onclick="showAddModal()">
                <h3>Add New Facility</h3>
            </div>
        </div>
    </div>

    <!-- Edit/Delete Modal -->
    <div id="editDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit or Delete Facility</h2>
            <p>Please select an action for <span id="selectedMember"></span>:</p>
            <button onclick="editMember()">Edit</button>
            <button onclick="deleteMember(document.getElementById('selectedMember').value)">Delete</button>
            <button id="viewAvailabilityButton">View Availability</button>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Add New Member</h2>
            <form id="addMemberForm" action="add_facility.php" method="POST">
            <label for="roomNo">Room Number:</label>
<input type="text" id="roomNo" name="roomNo" required><br><br>
<label for="description">Description:</label>
<input type="text" id="description" name="description" required><br><br>
<label for="building">Building:</label>
<input type="text" id="building" name="building" required><br><br>
<label for="noSeats">Number of Seats:</label>
<input type="number" id="noSeats" name="noSeats" required><br><br>
<label for="type">Type:</label>
<select id="type" name="type" required>
    <option value="Classroom">Classroom</option>
    <option value="Laboratory">Laboratory</option>
    <option value="Conference Room">Conference Room</option>
    <option value="Locker Room">Locker</option>
    <option value=" Library"> Library</option>
    <option value=" Gym"> Gym</option>
    <!-- Add more options if needed -->
</select><br><br>
<button type="submit">Add Facility</button>

            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit Facility</h2>
            <form id="editMemberForm" method="post" action="edit_facility.php">
            <input type="text" id="selectedMemberId" name="selectedMemberId">

                <label for="editMemberName">Room No:</label>
                <input type="text" id="editMemberName" name="editMemberName" required><br><br>
                <label for="editEmail">Description:</label>
                <input type="text" id="editEmail" name="editEmail" required><br><br>
                <label for="editPosition">Type:</label>
                <select id="editPosition" name="editPosition" required>
                    <option value="Theatre">Theatre</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Locker">Locker</option>
                    <option value="Laboratory">Laboratory</option>
                    <option value="Gym">Gym</option>
                    <option value="Library">Library</option>
                </select><br><br>
                <label for="editJoinDate">No of Seats:</label>
                <input type="number" id="editJoinDate" name="editJoinDate" required><br><br>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Function to show edit/delete modal
        function showOptionsModal(ID,	
            RoomNo,	
            Description,
            Building,	
            Noseats,	
            Type) {
            document.getElementById('selectedMemberId').value = ID;

            document.getElementById('editDeleteModal').style.display = 'flex';
            document.getElementById('editMemberName').value = RoomNo;
            document.getElementById('editEmail').value = Description;
            document.getElementById('editPosition').value = Type;
            document.getElementById('editJoinDate').value = Noseats;
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

        // Function to edit member
        function editMember() {
            // Retrieve member information
            const memberName = document.getElementById('editMemberName').value;
            const email = document.getElementById('editEmail').value;
            const position = document.getElementById('editPosition').value;
            const joinDate = document.getElementById('editJoinDate').value;
            const id = document.getElementById('selectedMember').value;
            // Populate fields in the edit modal with existing member information
            document.getElementById('editMemberName').value = memberName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPosition').value = position;
            document.getElementById('editJoinDate').value = joinDate;
            document.getElementById('selectedMember').value = id;
            // Display the edit modal
            document.getElementById('editModal').style.display = 'flex';
        }

        // Function to delete member
        function deleteMember(memberId) {
        if (confirm('Are you sure you want to delete this facility?')) {
            // Send deletion request to server
            fetch(`facilities.php?deleteId=${memberId}`, {
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
        /*document.getElementById('editMemberForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const editedMemberName = document.getElementById('editMemberName').value;
            const editedEmail = document.getElementById('editEmail').value;
            const editedPosition = document.getElementById('editPosition').value;
            const editedJoinDate = document.getElementById('editJoinDate').value;
            alert(`Member details edited successfully:\nName: ${editedMemberName}\nEmail: ${editedEmail}\nPosition: ${editedPosition}\nJoin Date: ${editedJoinDate}`);
            hideModal();
        });*/
    </script>
</body>
</html>