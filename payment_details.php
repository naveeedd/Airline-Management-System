<?php
	session_start();
?>
<html>
	<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32"/>
    <title>Fast Airlines</title>
		<style>

        body {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			background-color: #f4f4f4;
		}

		form {
			max-width: 800px;
			margin: 20px auto;
			padding: 20px;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h2, h3 {
			color: black;
			margin-bottom: 20px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
		}

		th, td {
			padding: 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		input {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1.5px solid #030337;
			border-radius: 4px;
			box-sizing: border-box;
		}

		input[type=submit] {
			background-color: #030337;
			color: white;
			border: none;
			border-radius: 4px;
			padding: 15px;
			cursor: pointer;
			font-size: 16px;
		}

		input[type=submit]:hover {
			background-color: #2d4371;
		}

		.payment-mode-label {
			display: flex;
			align-items: center;
			margin-bottom: 15px;
		}



		</style>
       
	</head>
    <nav>
    <div class="nav__logo">Fast Airlines</div>
    <ul class="nav__links">
      <li class="link"><a href="index.php">Home</a></li>
      <li class="link"><a href="flights.php">Flight Status</a></li>
      <li class="link"><a href="book.php">Book</a></li>
      <li class="link"><a href="cancel.php">Cancel Booking</a></li>
      <li class="link"><a href="about.php">About</a></li>
      <li class="link"><a href="contact.php">Contact</a></li>
    </ul>
    <button class="btn"><a href="login_page.php">Logout</a></button>
  </nav>
		<form action="payment_details_form_handler.php" method="post">
            <br>
            <br>
			<h3 style="margin-left: 30px"><u>Payment Summary</u></h3>
			<?php
				$flight_no=$_SESSION['flight_no'];
				$journey_date=$_SESSION['journey_date'];
				$no_of_pass=$_SESSION['no_of_pass'];
				$total_no_of_meals=$_SESSION['total_no_of_meals'];
				$payment_id=rand(100000000,999999999);
				$pnr=$_SESSION['pnr'];
				$_SESSION['payment_id']=$payment_id;
				$payment_date=date('Y-m-d'); 
				$_SESSION['payment_date']=$payment_date;


				require_once('Database Connection file/mysqli_connect.php');
				if($_SESSION['class']=='economy')
				{	
					$query="SELECT price_economy FROM Flight_Details where flight_no=? and departure_date=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ss",$flight_no,$journey_date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$ticket_price);
					mysqli_stmt_fetch($stmt);
				}
				else if($_SESSION['class']=='business')
				{
					$query="SELECT price_business FROM Flight_Details where flight_no=? and departure_date=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ss",$flight_no,$journey_date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$ticket_price);
					mysqli_stmt_fetch($stmt);
				}
				mysqli_stmt_close($stmt);
				mysqli_close($dbc);
				$total_ticket_price=$no_of_pass*$ticket_price;
				$total_meal_price=250*$total_no_of_meals;
				if($_SESSION['insurance']=='yes')
				{
					$total_insurance_fee=100*$no_of_pass;
				}
				else
				{
					$total_insurance_fee=0;
				}
				if($_SESSION['priority_checkin']=='yes')
				{
					$total_priority_checkin_fee=200*$no_of_pass;
				}
				else
				{
					$total_priority_checkin_fee=0;
				}
				if($_SESSION['lounge_access']=='yes')
				{
					$total_lounge_access_fee=300*$no_of_pass;
				}
				else
				{
					$total_lounge_access_fee=0;
				}
				$total_discount=0;
				$total_amount=$total_ticket_price+$total_meal_price+$total_insurance_fee+$total_priority_checkin_fee+$total_lounge_access_fee+$total_discount;
				$_SESSION['total_amount']=$total_amount;

				echo "<table cellpadding=\"5\"	style='margin-left: 50px'>";
				echo "<tr>";
				echo "<td class=\"fix_table\">Base Fare, Fuel and Transaction Charges (Fees & Taxes included):</td>";
				echo "<td class=\"fix_table\"> ".$total_ticket_price."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"fix_table\">Meal Combo Charges:</td>";
				echo "<td class=\"fix_table\">".$total_meal_price."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"fix_table\">Priority Checkin Fees:</td>";
				echo "<td class=\"fix_table\">".$total_priority_checkin_fee."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"fix_table\">Lounge Access Fees:</td>";
				echo "<td class=\"fix_table\">".$total_lounge_access_fee."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"fix_table\">Insurance Fees:</td>";
				echo "<td class=\"fix_table\">".$total_insurance_fee."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"fix_table\">Discount:</td>";
				echo "<td class=\"fix_table\">".$total_discount."</td>";
				echo "</tr>";

				echo "</table>";

				echo "<hr style='margin-right:900px; margin-left: 50px'>";
				echo "<table cellpadding=\"5\" style='margin-left: 50px'>";
				echo "<tr>";
				echo "<td class=\"fix_table\"><strong>Total:</strong></td>";
				echo "<td class=\"fix_table\">".$total_amount."</td>";
				echo "</tr>";
				echo "</table>";
				echo "<hr>";
				echo "<br>";
				echo "<p style=\"margin-left:50px\">Your Payment/Transaction ID is <strong>".$payment_id.".</strong> Please note it down for future reference.</p>";
				echo "<br>";
			?>
			<table cellpadding="5" style='margin-left: 50px'>
				<tr>
					<td class="fix_table"><strong>Enter the Payment Mode:-</strong></td>
				</tr>
				<tr>
					<td class="fix_table"><i class="fa fa-credit-card" aria-hidden="true"></i> Credit Card <input type="radio" name="payment_mode" value="credit card" checked></td>
					<td class="fix_table"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Debit Card <input type="radio" name="payment_mode" value="debit card"></td>
					<td class="fix_table"><i class="fa fa-desktop" aria-hidden="true"></i> Net Banking <input type="radio" name="payment_mode" value="net banking"></td>
				</tr>
			</table>
			<br>
			<input type="submit" value="Pay Now" name="Pay_Now">
		</form>
		<!-- 
•	Booking_Status
•	Payment_ID -->

		<!--Following data fields were empty!
			...
			ADD VIEW FLIGHT DETAILS AND VIEW JETS/ASSETS DETAILS for ADMIN
			PREDEFINED LOCATION WHEN BOOKING TICKETS
		-->

        <footer class="footer">
        <div class="section__container footer__container">
            <div class="footer__col">
                <h3>Fast Airlines</h3>
                <p>
                    Where Excellence Takes Flight. With a strong commitment to customer
                    satisfaction and a passion for air travel, Fast Airlines offers
                    exceptional service and seamless journeys.
                </p>
                <p>
                    From friendly smiles to state-of-the-art aircraft, we connect the
                    world, ensuring safe, comfortable, and unforgettable experiences.
                </p>
            </div>
            <div class="footer__col">
                <h4>INFORMATION</h4>
                <p>Home</p>
                <p>About</p>
                <p>Book</p>
                <p>Flights</p>
            </div>
            <div class="footer__col">
                <h4>CONTACT</h4>
                <p>Support</p>
                <p>Media</p>
                <p>Socials</p>
            </div>
        </div>
        <div class="section__container footer__bar">
            <p>Copyright © 2023 Fast Airlines. All rights reserved.</p>
            <div class="socials">
                <span><i class="ri-facebook-fill"><a href="#"></a></i></span>
                <span><i class="ri-twitter-fill"></i></span>
                <span><i class="ri-instagram-line"></i></span>
                <span><i class="ri-youtube-fill"></i></span>
            </div>
        </div>
    </footer>
	</body>
</html>