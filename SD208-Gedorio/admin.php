<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$listSql = "SELECT id, full_name, username, email, age, gender, status FROM users";
$listResult = $conn->query($listSql);
if ($listResult === false) {
    die("List query failed: " . $conn->error);
}

$genderData = array("Male" => 0, "Female" => 0, "Other" => 0);
$ageData = array("0-20" => 0, "21-40" => 0, "41-60" => 0, "61+" => 0);

// Fetch data for the gender pie chart
$chartSql = "SELECT gender FROM users";
$chartResult = $conn->query($chartSql);

if ($chartResult->num_rows > 0) {
    while ($row = $chartResult->fetch_assoc()) {
        $gender = $row["gender"];
        if (array_key_exists($gender, $genderData)) {
            $genderData[$gender]++;
        }
    }
}
//Fetch data for the age pie chart
$ageSql = "SELECT age FROM users";
$ageResult = $conn->query($ageSql);

if ($ageResult->num_rows > 0) {
    while ($row = $ageResult->fetch_assoc()) {
        $age = (int)$row['age'];
        if ($age <= 20) {
            $ageData["0-20"]++;
        } elseif ($age <= 40) {
            $ageData["21-40"]++;
        } elseif ($age <= 60) {
            $ageData["41-60"]++;
        } else {
            $ageData["61+"]++;
        }
    }
}

// SQL query to fetch activities by month
$activitySql = "SELECT MONTH(activity_date) AS month, COUNT(*) AS activity_count FROM activities GROUP BY month";

$activityResult = $conn->query($activitySql);
if ($activityResult === false) {
    die("Activity query failed: " . $conn->error);
}

$monthLabels = array(
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
);

$activityData = array_fill(0, 12, 0); 

//activity result
while ($row = $activityResult->fetch_assoc()) {
    $month = (int)$row['month'];
    $activityCount = (int)$row['activity_count'];
    $activityData[$month - 1] = $activityCount;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Daily Hub - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="adminSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admind.php">
                <div class="sidebar-brand-text mx-3">Daily Hub Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                List    
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                </div>
                
                <!-- List of Members/Users box -->
                <div class="col-lg-10" id="listOfMembers" style="width:1000px;">
                    <div class="card mb-4" style="width: 1080px;">
                        <div class="card-header">
                            List of Members/Users
                        </div>
                        <div class="card-body">
                        <div class="table-responsive" style="max-height: 400px; width:1000px; overflow: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th> 
                                        </tr>
                                     </thead>
                                    <tbody>
                                         <?php
                                            while ($row = $listResult->fetch_assoc()) {
                                                $statusClass = $row['status'] == 1 ? 'text-success' : 'text-danger';
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['full_name']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['gender']; ?></td>
                                                    <td><?php echo $row['age']; ?></td>
                                                    <td><span class="<?php echo $statusClass; ?>"><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></span></td>
                                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo $row['full_name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['gender']; ?>')">Edit</button>
                                        <!-- <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?php echo $row['id']; ?>', '<?php echo $row['full_name']; ?>')">Delete</button> -->
                                        </td>
                                         </tr>
                                        <?php } ?>
                                     </tbody>
                                </table>
                             </div>
                        </div>

                    </div>
                </div>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Add a form here to edit user details -->
                                <form method="POST" action="edit_user.php">
                                    <input type="hidden" id="editUserId" name="editUserId">
                                    <div class="form-group">
                                        <label for="editFullName">Full Name</label>
                                        <input type="text" class="form-control" id="editFullName" name="editFullName">
                                    </div>
                                    <div class="form-group">
                                        <label for="editEmail">Email</label>
                                        <input type="email" class="form-control" id="editEmail" name="editEmail">
                                    </div>
                                    <div class="form-group">
                                        <label for="editGender">Gender</label>
                                        <input type="text" class="form-control" id="editGender" name="editGender">
                                    </div>
                                    <div class="form-group">
                                        <label for="editAge">Age</label>
                                        <input type="text" class="form-control" id="editAge" name="editAge">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete User Modal -->
                <!-- <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the user "<span id="deleteUserName"></span>"?
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="delete_user.php">
                                    <input type="hidden" id="deleteUserId" name="deleteUserId">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->

                 <!-- Pie Chart of Gender box -->
                <div class="col-lg-6" id="pieChart">
                    <div class="card mb-4">
                        <div class="card-header">
                             Pie Chart of Gender
                            </div>
                            <div class="card-body">
                            <canvas id="genderPieChart" width="100%" height="53"></canvas>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-6" id="pieChart">
                    <div class="card mb-4">
                        <div class="card-header">
                            Pie Chart of Age
                        </div>
                        <div class="card-body">
                            <canvas id="agePieChart" width="100%" height="53"></canvas>
                        </div>
                    </div>
                </div>

                        <!-- Clear the float -->
                        <div class="clearfix"></div>
                    
                    <!-- Bar Graph of Activities from January to December -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Bar Graph of Activities from January to December
                                </div>
                                <div class="card-body">
                                    <canvas id="activityBarChart" width="100%" height="20"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!-- Manage Announcements -->
                    <div class="row" id="announcement">
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Manage Announcements
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="create_announcement.php">
                                        <div class="form-group">
                                            <label for="announcementTitle">Announcement Title</label>
                                            <input type="text" class="form-control" id="announcementTitle" name="announcementTitle">
                                        </div>
                                        <div class="form-group">
                                            <label for="announcementContent">Announcement Content</label>
                                            <textarea class="form-control" id="announcementContent" name="announcementContent" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Announcement</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function openEditModal(userId, fullName, email, gender, age) {
        $('#editUserId').val(userId);
        $('#editFullName').val(fullName);
        $('#editEmail').val(email);
        $('#editGender').val(gender);
        $('#editAge').val(age);
        $('#editUserModal').modal('show');
    }

    // Function to open the delete user modal
    function openDeleteModal(userId, fullName) {
        $('#deleteUserId').val(userId);
        $('#deleteUserName').text(fullName);
        $('#deleteUserModal').modal('show');
    }

    //genderData and PieChart Function
    var genderData = {
        labels: ['Male', 'Female', 'Other'],
        datasets: [{
            data: [<?php echo $genderData["Male"]; ?>, <?php echo $genderData["Female"]; ?>, <?php echo $genderData["Other"]; ?>],
            backgroundColor: ['#007bff', '#FFFF00', '#7f00ff'],
        }]
    };

    var genderPieChartCanvas = document.getElementById('genderPieChart').getContext('2d');

    var genderPieChart = new Chart(genderPieChartCanvas, {
        type: 'pie',
        data: genderData,
    });

        // ageData and AgePieChart Function
    var ageData = {
        labels: ['0-20', '21-40', '41-60', '61+'],
        datasets: [{
            data: [
                <?php echo $ageData["0-20"]; ?>,
                <?php echo $ageData["21-40"]; ?>,
                <?php echo $ageData["41-60"]; ?>,
                <?php echo $ageData["61+"]; ?>
            ],
            backgroundColor: ['orange', 'green', '#7f00ff', '#ff6361'],
        }]
    };

    var agePieChartCanvas = document.getElementById('agePieChart').getContext('2d');

    var agePieChart = new Chart(agePieChartCanvas, {
        type: 'pie',
        data: ageData,
    });


    //activityData that requested Json
    var activityData = {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
            label: 'Activities',
            data: <?php echo json_encode($activityData); ?>,
            backgroundColor: '#ff6361',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]  
    };

    var activityBarChartCanvas = document.getElementById('activityBarChart').getContext('2d');

    var activityBarChart = new Chart(activityBarChartCanvas, {
        type: 'bar',
        data: activityData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }); 

</script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</html>