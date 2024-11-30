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


// Handle the ticket search form submission
$searchResults = "";
if (isset($_POST['Submit'])) {
    $flight_no = trim($_POST['flight_no'] ?? '');
    $departure_date = $_POST['departure_date'] ?? '';

    if (!empty($flight_no) && !empty($departure_date)) {
        $query = "SELECT pnr, date_of_reservation, class, no_of_passengers, payment_id, customer_id
                  FROM Ticket_Details 
                  WHERE flight_no = ? AND journey_date = ? AND booking_status = 'CONFIRMED' 
                  ORDER BY class";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "ss", $flight_no, $departure_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pnr, $date_of_reservation, $class, $no_of_passengers, $payment_id, $customer_id);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            $searchResults = "<h1 class='text-center text-red-500'>No booked tickets information is available!</h1>";
        } else {
            $searchResults = "<table class='table-auto w-full border-collapse border border-gray-300 mt-6'>
                                <thead class='bg-blue-600 text-white'>
                                    <tr>
                                        <th class='px-4 py-2'>PNR</th>
                                        <th class='px-4 py-2'>Date of Reservation</th>
                                        <th class='px-4 py-2'>Class</th>
                                        <th class='px-4 py-2'>No. of Passengers</th>
                                        <th class='px-4 py-2'>Payment ID</th>
                                        <th class='px-4 py-2'>Customer ID</th>
                                    </tr>
                                </thead>
                                <tbody>";
            while (mysqli_stmt_fetch($stmt)) {
                $searchResults .= "<tr class='border border-gray-300'>
                                     <td class='px-4 py-2'>{$pnr}</td>
                                     <td class='px-4 py-2'>{$date_of_reservation}</td>
                                     <td class='px-4 py-2'>{$class}</td>
                                     <td class='px-4 py-2'>{$no_of_passengers}</td>
                                     <td class='px-4 py-2'>{$payment_id}</td>
                                     <td class='px-4 py-2'>{$customer_id}</td>
                                   </tr>";
            }
            $searchResults .= "</tbody></table>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $searchResults = "<h1 class='text-center text-red-500'>Please fill out all fields.</h1>";
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

          

        <!-- Search Form -->
        <form action="" method="POST" class="mt-8 bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Search Booked Tickets</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" name="flight_no" placeholder="Flight No." class="p-2 border rounded">
                <input type="date" name="departure_date" class="p-2 border rounded">
            </div>
            <button type="submit" name="Submit" class="bg-blue-600 text-white px-6 py-2 mt-4 rounded">Submit</button>
        </form>
		        <!-- Search Results -->
				<div class="mt-8">
            <?= $searchResults ?>
        </div>
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


