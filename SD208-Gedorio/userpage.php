<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$announcements = array(); 

$query = "SELECT * FROM announcements"; 
$result = mysqli_query($conn, $query);


if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announcements[] = $row;
    }
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Activity</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Userpages.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-primary bg-light">
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo '<span class="navbar-text mr-auto"style="color: blue; font-weight:500;">Welcome, ' . $_SESSION['username'] . '</span>';
            echo '<a class="nav-link" id="log" href="index.php">Logout</a>';
        }
        ?>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-5" id="Activity">
                <h2 class="HeadAct">Add New Activity</h2>
                <form action="add_activity.php" method="POST" id="activity-form">
                    <div class="form-group">
                        <label for="activity_name">Activity Name:</label>
                        <input type="text" class="form-control" id="activity_name" name="activity_name" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_date">Date:</label>
                        <input type="date" class="form-control" id="activity_date" name="activity_date" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_time">Time:</label>
                        <input type="time" class="form-control" id="activity_time" name="activity_time" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_location">Location:</label>
                        <input type="text" class="form-control" id="activity_location" name="activity_location">
                    </div>
                    <div class="form-group">
                        <label for="activity_ootd">OOTD:</label>
                        <input type="text" class="form-control" id="activity_ootd" name="activity_ootd">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Add Activity</button>
                    </div>
                </form>
                <div id="success-message" style="display: none;"></div>
            </div>

            <div class="col-lg-4">
                <div class="Announcement">
                    <h2 class="HeadAct">Announcement</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    <button class="btn btn-primary" id="viewAnnouncementButton">View Announcement</button>
                </div>
            </div>

           <!-- Display announcements in a modal -->
           <div class="modal fade" id="viewAnnouncementsModal" tabindex="-1" role="dialog" aria-labelledby="viewAnnouncementsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" id="Header">
                            <h5 class="modal-title" id="viewAnnouncementsModalLabel">View Announcements</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeAnnouncementModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                            <?php foreach ($announcements as $announcement) { ?>
                                <h3 style="text-align: center; font-weight: bold;"><?php echo $announcement['title']; ?></h3>
                                <p><?php echo $announcement['content']; ?></p>
                                <hr>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeAnnouncementModal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3">
                <div class="ShowActivity">
                    <h2 class="HeadAct">Show Activities</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    <button class="btn btn-primary" id="showActivitiesButton">Show Activities</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showActivitiesModal" tabindex="-1" role="dialog" aria-labelledby="showActivitiesModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="margin-top:1Srem">
                    <div class="modal-header" id="Header">
                        <h5 class="modal-title" id="showActivitiesModalLabel">Activities</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="ActBody" style="max-height: 500px; overflow-y: auto;">
                        <?php
                        $query = "SELECT * FROM activities ORDER BY activity_date ASC";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Display each activity in the modal body
                                echo "<h3>{$row['activity_name']}</h3>";
                                echo "<p>Date: {$row['activity_date']}</p>";
                                echo "<p>Time: {$row['activity_time']}</p>";
                                echo "<p>OOTD: {$row['activity_ootd']}</p>";
                                echo "<p>Location: {$row['activity_location']}</p>";
                                echo "<hr>";
                            }
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12" id="TableActivity">
                <h2 class="listAct">Activity List</h2>
                <div class="table-responsive scrollable-table">
                    <table class="table table-striped">  
                        <tbody>
                            <?php include("Activity_php/showAll.php"); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <div id="edit-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close" onclick="closeEditModal()">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="edit-container">
                <button onclick="editActivity(${activity.id})">Edit</button>

                    <!-- Inside edit modal content -->
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="UserPages.js"></script>
</html>
