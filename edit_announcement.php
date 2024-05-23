<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'swe417');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $memberId = $_POST['selectedMemberId'];
    $editedMemberName = $_POST['editMemberName'];
    $editedEmail = $_POST['editMemberFullname'];
    $editedPosition = $_POST['editPosition'];
    $editedJoinDate = $_POST['editJoinDate'];

    // Update member information in the database
    $sql = "UPDATE Announcements SET Title='$editedMemberName', Content='$editedEmail', Receivers='$editedPosition', Date='$editedJoinDate' WHERE id='$memberId'";

    if (mysqli_query($conn, $sql)) {
        echo "Announcement information updated successfully";
    } else {
        echo "Error updating Announcement information: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
