<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Manage Members</title>
    <link rel="stylesheet" href="graduation.css">
    <style>
        body { 
    background: none;
    background-color:#C8AE81;
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

        /* Member List Styles */
        .member-list {
            display: flex;
            flex-wrap: wrap;
            gap:20px;
            margin-top: 10px;
        }

        .member-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .member-card:hover {
            transform: translateY(-5px);
        }

        .member-card h3 {
            margin-top: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .member-card p {
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
            background-color:rgba(128, 0, 0, 0.795);
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
           <a href="facilities.php">Facilities</a>
           <a href="logout.html" target="_blank">Log Out</a>
        </nav>
    </header>

    <div class="container">
        <h1>Manage Members</h1>
        <hr class="separator">

        <!-- Member List -->
        <div class="member-list">
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
    $deleteSql = "DELETE FROM users WHERE id = $deleteId";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Member deleted successfully";
    } else {
        echo "Error deleting member: " . mysqli_error($conn);
    }
}

            // Query to retrieve member information
            $sql = "SELECT id, username, email, role, full_name, join_date FROM users WHERE role IN ('faculty', 'student')";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output member cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="member-card" onclick="showOptionsModal(' . $row['id'] . ', \'' . $row['username'] . '\', \'' . $row['email'] . '\', \'' . $row['role'] . '\', \'' . $row['full_name'] . '\', \'' . $row['join_date'] . '\')">';
                    echo '<h3>' . $row['full_name'] . '</h3>';
                    echo '<p>ID: ' . $row['id'] . '<br>Email: ' . $row['email'] . '<br>Position: ' . $row['role'] . '<br>Join Date: ' . $row['join_date'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No members found";
            }

            // Close connection
            mysqli_close($conn);
            ?>
            <div class="member-card" onclick="showAddModal()">
                <h3>Add New Member</h3>
            </div>
        </div>
    </div>

    <!-- Edit/Delete Modal -->
    <div id="editDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit or Delete Member</h2>
            <p>Please select an action for <span id="selectedMemberRole"></span><span id="selectedMember"></span>:</p>
            <button onclick="editMember()">Edit</button>
            <button onclick="deleteMember(document.getElementById('selectedMember').value)">Delete</button>
            <button id="viewReservationsButton">View Reservations</button>

        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Add New Member</h2>
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit Member</h2>
            <form id="editMemberForm" method="post" action="edit_member.php">
    <input type="text" id="selectedMemberId" name="selectedMemberId">
    <label for="editMemberName">Username:</label>
    <input type="text" id="editMemberName" name="editMemberName" required><br><br>
    <label for="editMemberFullname">Full Name:</label>
    <input type="text" id="editMemberFullname" name="editMemberFullname" required><br><br>

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
        function showOptionsModal(id, name, email, position, fullName, joinDate) {
            document.getElementById('selectedMember').value = id;
            document.getElementById('selectedMember').textContent = name;
            document.getElementById('selectedMemberId').value = id;
            document.getElementById('selectedMemberRole').value = position;
            document.getElementById('editDeleteModal').style.display = 'flex';
            document.getElementById('editMemberName').value = name;
            document.getElementById('editMemberFullname').value = fullName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPosition').value = position;
            document.getElementById('editJoinDate').value = joinDate;

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
        document.getElementById("viewReservationsButton").addEventListener("click", function() {
    // Get the value you want to pass as a parameter
    var parameterValue = document.getElementById('selectedMember').value;
    var parameterValue2 = document.getElementById('selectedMemberRole').value;
    // Construct the URL with the parameter
    var url = "user_reservations.php?userId=" + encodeURIComponent(parameterValue) + "&role=" +encodeURIComponent(parameterValue2);
    
    // Navigate to the new page
    window.location.href = url;
});

        // Function to edit member
        function editMember() {
            // Retrieve member information
            const memberName = document.getElementById('editMemberName').textContent;
            const email = document.getElementById('editEmail').value;
            const position = document.getElementById('editPosition').value;
            const joinDate = document.getElementById('editJoinDate').value;
                
            // Populate fields in the edit modal with existing member information
            document.getElementById('editMemberName').value = memberName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPosition').value = position;
            document.getElementById('editJoinDate').value = joinDate;

            // Display the edit modal
            document.getElementById('editModal').style.display = 'flex';
        }

        // Function to delete member
        function deleteMember(memberId) {
        if (confirm('Are you sure you want to delete this member?')) {
            // Send deletion request to server
            fetch(`members.php?deleteId=${memberId}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Display message from server
                // Reload the page or update member list as needed
                location.reload(); // Example: Reload the page after deletion
            })
            .catch(error => console.error('Error deleting member:', error));
        }
    }

    </script>
</body>
</html>