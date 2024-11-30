<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    // Redirect to login page if session is not active
    header('location: login_page.php');
    exit;
}

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

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="css/index.css" />
    <title>Admin Dashboard</title>
	<style>
	form {
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 10px;
  width: 100%; /* Set form width to 100% of its container */
  margin-left: auto;
  margin-right: auto; /* Auto margins for centering */
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}


form table {
  width: 100%;
  margin-bottom: 15px;
}

form table .fix_table {
  text-align: left;
  font-weight: bold;
  padding: 8px 0;
}

form input[type="text"],
form input[type="date"],
form input[type="time"],
form input[type="number"] {
  width: calc(100% - 20px);
  padding: 10px;
  margin: 5px 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form input[type="submit"] {
  background-color: #004c8c;
  color: white;
  padding: 12px 20px;
  font-size: 1em;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

form input[type="submit"]:hover {
  background-color: #003366;
}

strong {
  display: block;
  margin-bottom: 15px;
  font-size: 1.1em;
}

hr {
  border: 0;
  height: 1px;
  background: #ddd;
  margin: 20px 0;
}


		</style>
	
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
            <span>ENTER THE FLIGHT SCHEDULE DETAILS</span>
          </div>
		<form action="add_flight_details_form_handler.php" method="post"  >
			<?php
				if(isset($_GET['msg']) && $_GET['msg']=='success')
				{
					echo "<strong style='color: green'>The Flight Schedule has been successfully added.</strong>
						<br>
						<br>";
				}
				else if(isset($_GET['msg']) && $_GET['msg']=='failed')
				{
					echo "<strong style='color: red'>*Invalid Flight Schedule Details, please enter again.</strong>
						<br>
						<br>";
				}
			?>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Flight Number</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="text" name="flight_no" required></td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Departure</td>
					<td class="fix_table">Destination</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="text" name="origin" required></td>
					<td class="fix_table"><input type="text" name="destination" required></td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Departure Date</td>
					<td class="fix_table">Arrival Date</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="date" name="dep_date" required></td>
					<td class="fix_table"><input type="date" name="arr_date" required></td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Departure Time</td>
					<td class="fix_table">Arrival Time</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="time" name="dep_time" required></td>
					<td class="fix_table"><input type="time" name="arr_time" required></td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Number of Seats in Economy Class</td>
					<td class="fix_table">Number of Seats in Business Class</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="number" name="seats_eco" required></td>
					<td class="fix_table"><input type="number"" name="seats_bus" required></td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Ticket Price(Economy Class)</td>
					<td class="fix_table">Ticket Price(Business Class)</td>
				</tr>
			</table>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">
						<input type="number" name="price_eco" required>
					</td>
					<td class="fix_table">
						<input type="number" name="price_bus" required>
					</td>
				</tr>
			</table>
			<br>
			<hr>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Aircraft ID</td>
				</tr>
				<tr>
					<td class="fix_table">
						<input type="text" name="jet_id" required>
					</td>
				</tr>
			</table>
			<br>
			<input type="submit" value="Submit" name="Submit">
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

