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

            <a href="myRe.php">My Reservations</a>
            <a href="faservices.php">Student Services</a>
            <a href="about.html">About Us</a>
            <a href="logout.html" >Log Out</a>
        </nav>
    </header>

    <div class="container">
        <h1>Announcements</h1>
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
            // Query to retrieve member information
            $sql = "SELECT ID, Title, Content FROM announcements WHERE Receivers IN ('faculty', 'all')";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output member cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="member-card" >';
                    echo '<h3>' . $row['Title'] . '</h3>';
                    echo '<p>'. $row['Content'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No members found";
            }

            // Close connection
            mysqli_close($conn);
            ?>
           
        </div>
    </div>

    <!-- Edit/Delete Modal -->
   

    
</body>
</html>