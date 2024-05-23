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
    $editedMemberFullname = $_POST['editMemberFullname'];
    $editedEmail = $_POST['editEmail'];
    $editedPosition = $_POST['editPosition'];
    $editedJoinDate = $_POST['editJoinDate'];

    // Update member information in the database
    $sql = "UPDATE users SET username='$editedMemberName', full_name='$editedMemberFullname', email='$editedEmail', role='$editedPosition', join_date='$editedJoinDate' WHERE id=$memberId";

    if (mysqli_query($conn, $sql)) {
        echo "Member information updated successfully";
    } else {
        echo "Error updating member information: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
