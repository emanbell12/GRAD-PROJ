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
            <a href="members.php">Members</a>
           <a href="facilities.php">Facilities</a>
           <a href="logout.html" target="_blank">Log Out</a>
        </nav>
    </header>

    <div class="container">
        <h1>Manage Announcements</h1>
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
    $deleteSql = "DELETE FROM announcements WHERE ID = $deleteId";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Announcement deleted successfully";
    } else {
        echo "Error deleting announcement: " . mysqli_error($conn);
    }
}

            // Query to retrieve member information
            $sql = "SELECT ID, Title, Content, Receivers, Date FROM announcements";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output member cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="member-card" onclick="showOptionsModal(' . $row['ID'] . ', \'' . $row['Title'] . '\', \'' . $row['Content'] . '\', \'' . $row['Receivers'] . '\', \'' . $row['Date'] . '\')">';
                    echo '<h3>' . $row['Title'] . '</h3>';
                    echo '<p>ID: ' . $row['ID'] . '<br>Content: ' . $row['Content'] . '<br>Receivers: ' . $row['Receivers'] . '<br>Date: ' . $row['Date'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No Announcements found";
            }

            // Close connection
            mysqli_close($conn);
            ?>
            <div class="member-card" onclick="showAddModal()">
                <h3>Add New Announcement</h3>
            </div>
        </div>
    </div>

    <!-- Edit/Delete Modal -->
    <div id="editDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit or Delete Announcement</h2>
            <p>Please select an action for <span id="selectedMember"></span>:</p>
            <button onclick="editMember()">Edit</button>
            <button onclick="deleteMember(document.getElementById('selectedMember').value)">Delete</button>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Add New Announcement</h2>
            <form id="addMemberForm" action="add_announcement.php" method="POST">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="content">Content:</label>
                <input type="text" id="content" name="content" required><br><br>
                <label for="reciever">Recievers:</label>
                <select id="reciever" name="reciever" required>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="All">All</option>
                </select><br><br>
                <button type="submit">Add Announcement</button>
            </form>
        </div>
    </div>

     <!-- Edit Modal -->
     <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <div class="return-arrow" onclick="hideModal()">&#8592;</div>
            <h2>Edit Announcement</h2>
            <form id="editMemberForm" method="post" action="edit_announcement.php">
    <input type="hidden" id="selectedMemberId" name="selectedMemberId">
    <label for="editMemberName">Title:</label>
    <input type="text" id="editMemberName" name="editMemberName" required><br><br>
    <label for="editMemberFullname">Content:</label>
    <input type="text" id="editMemberFullname" name="editMemberFullname" required><br><br>
    <label for="editPosition">Receivers:</label>
    <select id="editPosition" name="editPosition" required>
        <option value="Student">Student</option>
        <option value="Faculty">Faculty</option>
        <option value="Faculty">All</option>
    </select><br><br>
    <input type="hidden" id="editJoinDate" name="editJoinDate" required><br><br>
    <button type="submit">Save Changes</button>
</form>


        </div>
    </div>

    <script>
        // Function to show edit/delete modal
        function showOptionsModal(ID, Title, Content, Receivers, Date) {
            document.getElementById('selectedMember').value = ID;
            document.getElementById('editDeleteModal').style.display = 'flex';
            document.getElementById('selectedMemberId').value = ID;

            document.getElementById('editMemberName').value = Title;
            document.getElementById('editMemberFullname').value = Content;
            document.getElementById('editPosition').value = Receivers;
            document.getElementById('editJoinDate').value = Date;

        }
       
        function hideModal() {
            document.getElementById('editDeleteModal').style.display = 'none';
            document.getElementById('addModal').style.display = 'none';
            document.getElementById('editModal').style.display = 'none';
        }

        // Function to show add modal
        function showAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
       
        function editMember() {
            // Retrieve member information
            const memberName = document.getElementById('editMemberName').value;
            const full_name = document.getElementById('editMemberFullname').value;
            const position = document.getElementById('editPosition').value;
            var today = new Date();

            // Format date as YYYY-MM-DD (required by input type="date")
            var formattedDate = today.toISOString().substr(0, 10);
            // Populate fields in the edit modal with existing member information
            document.getElementById('editMemberName').value = memberName;
            document.getElementById('editMemberFullname').value = full_name;
            document.getElementById('editPosition').value = position;
            document.getElementById('editJoinDate').value = formattedDate;

            // Display the edit modal
            document.getElementById('editModal').style.display = 'flex';
        }


        function deleteMember(memberId) {
        if (confirm('Are you sure you want to delete this announcement?')) {
            // Send deletion request to server
            fetch(`announcements.php?deleteId=${memberId}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
              
                location.reload(); 
            })
            .catch(error => console.error('Error deleting announcement:', error));
        }
    }

    </script>
</body>
</html>