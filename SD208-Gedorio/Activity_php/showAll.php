<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM activities";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='activity-list'>";
    echo "<tr>";
    echo "<th>Activity Name</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Location</th>";
    echo "<th>OOTD</th>";
    echo "<th>Status</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td id='activity-" . $row["id"] . "-name'>" . $row["activity_name"] . "</td>";
        echo "<td id='activity-" . $row["id"] . "-date'>" . $row["activity_date"] . "</td>";
        echo "<td id='activity-" . $row["id"] . "-time'>" . $row["activity_time"] . "</td>";
        echo "<td>" . $row["activity_location"] . "</td>";
        echo "<td>" . $row["activity_ootd"] . "</td>";
        echo "<td>" . $row["activity_status"] . "</td>";

        // Action buttons
        echo "<td class='action-buttons'>";
        echo '<button onclick="cancelActivity(' . $row["id"] . ')" id="cancel">Cancel</button>';
        echo '<button onclick="markDone(' . $row["id"] . ')" id="done">Done</button>';
        echo '<button onclick="addRemarks(' . $row["id"] . ')">Remarks</button>';
        echo '<button onclick="editActivity(' . $row["id"] . ')" id="edit">Edit</button>';
        echo '<button onclick="deleteActivity(' . $row["id"] . ')" id="delete">Delete</button>';
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No activities found.";
}

$conn->close();
?>
