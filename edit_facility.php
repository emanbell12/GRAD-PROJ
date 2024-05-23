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
    $editedEmail = $_POST['editEmail'];
    $editedPosition = $_POST['editPosition'];
    $editedJoinDate = $_POST['editJoinDate'];

    // Update member information in the database
    $sql = "UPDATE facility SET RoomNo='$editedMemberName', Description='$editedEmail', Type='$editedPosition', Noseats='$editedJoinDate' WHERE id='$memberId'";

    if (mysqli_query($conn, $sql)) {
        echo "Facility information updated successfully";
    } else {
        echo "Error updating member information: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
