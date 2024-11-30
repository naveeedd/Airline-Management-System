<?php
	session_start();
?>
<?php
// Database connection
require_once('Database Connection file/mysqli_connect.php');

// Queries to calculate counts
$queryTotalFlights = "SELECT COUNT(*) AS total_flights FROM flight_details";
$queryActiveAircraft = "SELECT COUNT(*) AS active_aircraft FROM jet_details WHERE active = 'yes'";
$queryTodaysBookings = "SELECT SUM(no_of_passengers) AS todays_bookings 
                        FROM ticket_details 
                        WHERE date_of_reservation = CURDATE()";

// Fetch counts
$totalFlights = 0;
$activeAircraft = 0;
$todaysBookings = 0;

// Execute total flights query
if ($stmt = mysqli_prepare($dbc, $queryTotalFlights)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalFlights);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Execute active aircraft query
if ($stmt = mysqli_prepare($dbc, $queryActiveAircraft)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $activeAircraft);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Execute today's bookings query
if ($stmt = mysqli_prepare($dbc, $queryTodaysBookings)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $todaysBookings);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
  
// Define variables to hold error messages and success
$msg = '';
$flight_no = '';
$departure_date = '';

if (isset($_POST['Delete'])) {
    $data_missing = array();
    
    // Validate flight_no
    if (empty($_POST['flight_no'])) {
        $data_missing[] = 'Flight No.';
    } else {
        $flight_no = trim($_POST['flight_no']);
    }

    // Validate departure_date
    if (empty($_POST['departure_date'])) {
        $data_missing[] = 'Departure Date';
    } else {
        $departure_date = trim($_POST['departure_date']);
    }

    // Proceed if there are no missing data
    if (empty($data_missing)) {
        require_once('Database Connection file/mysqli_connect.php');
        
        $query = "DELETE FROM Flight_Details WHERE flight_no=? AND departure_date=?";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "ss", $flight_no, $departure_date);
        mysqli_stmt_execute($stmt);
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
        
        if ($affected_rows == 1) {
            $msg = 'success';
        } else {
            $msg = 'failed';
        }
    } else {
        $msg = 'missing_data';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="css/index.css" />
    <style>
        input {
            border: 1.5px solid #030337;
            border-radius: 4px;
            padding: 7px 30px;
        }

        input[type=submit] {
            background-color: #030337;
            color: white;
            border-radius: 4px;
            padding: 7px 45px;
            margin: 0px 390px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0px 0;
			margin-bottom: 0px;
            font-size: 12px;
            text-align: left;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        th, td {
            padding: 15px 5px;
        }

        th {
            background-color: #3d5cb8;
            color: white;
            text-transform: uppercase;
        }

        tr {
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:last-child {
            border-bottom: 2px solid #3d5cb8;
        }

        tr:hover {
            background-color: #e7ecfc;
            transition: background-color 0.3s ease;
        }
    </style>
    <title>Admin Dashboard</title>
</head>
<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="admin_homepage.php" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                        Fast Airlines
                    </span>
                </a>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, Admin</span>
                    <a href="login_page.php" class="flex items-center space-x-2 bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 3H21V21H15" />
                            <path d="M3 12H21" />
                            <path d="M6 9L3 12L6 15" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">
                Dashboard Overview
            </h1>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 font-medium">Total Flights</p>
                            <p class="text-2xl font-bold text-blue-800"><?= htmlspecialchars($totalFlights) ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 font-medium">Active Aircraft</p>
                            <p class="text-2xl font-bold text-blue-800"><?= htmlspecialchars($activeAircraft) ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 font-medium">Today's Bookings</p>
                            <p class="text-2xl font-bold text-blue-800"><?= htmlspecialchars($todaysBookings) ?></p>
                        </div>
                    </div>
                </div>
            </div>

           
    <div class="booking__nav">
        <span>ENTER THE FLIGHT SCHEDULE TO BE DELETED</span>
    </div>

    <?php
    if ($msg == 'success') {
        echo "<strong style='color:green; padding-left:20px;'>The Flight Schedule has been successfully deleted.</strong><br><br>";
    } elseif ($msg == 'failed') {
        echo "<strong style='color:red; padding-left:20px;'>*Invalid Flight No./Departure Date, please enter again.</strong><br><br>";
    } elseif ($msg == 'missing_data') {
        echo "<strong style='color:red; padding-left:20px;'>The following data fields were empty! <br> Please fill in all fields.</strong><br><br>";
    }
    ?>

    <form action="" method="post">
        <table cellpadding="5" style="display:flex; justify-content: center; margin-top: 1%">
            <tr>
                <td class="fix_table">Enter a valid Flight No.</td>
                <td class="fix_table">Enter the Departure Date</td>
            </tr>
            <tr>
                <td class="fix_table"><input type="text" name="flight_no" required></td>
                <td class="fix_table"><input type="date" name="departure_date" required></td>
            </tr>
        </table>
        <br><br>
        <div style="display:flex; justify-content: center;">
            <input type="submit" value="Delete" name="Delete">
        </div>
    </form>



            <!-- Quick Actions -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <a href="all_bookings.php" class="quick-action-btn">View All Flights</a>
                <a href="admin_view_booked_tickets.php" class="quick-action-btn">Search Booked Tickets</a>
                <a href="add_flight_details.php" class="quick-action-btn">Add Flight</a>
                <a href="delete_flight_details.php" class="quick-action-btn">Delete Flight</a>
                <a href="add_jet_details.php" class="quick-action-btn">Add Aircraft Details</a>
                <a href="activate_jet_details.php" class="quick-action-btn">Activate Aircraft</a>
                <a href="deactivate_jet_details.php" class="quick-action-btn">Deactivate Aircraft</a>
            </div>
        </div>
    </main>

</body>
</html>


  