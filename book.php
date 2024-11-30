<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
    <title>Fast Airlines</title>
    <style>
                    
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px; /* Reduced margin */
        }

        /* Table Header Styling */
        th, td {
            padding: 5px; /* Reduced padding */
            text-align: left;
            font-size: 1em; /* Slightly smaller font */
            border-bottom: 1px solid #dee2e6;
        }

        /* Header Background and Text Styling */
        th {
            background-color: #3d5cb8;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Table Row Hover Effect */
        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Alternating Row Colors */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Table Data Cell Styling */
        td {
            color: #555;
            font-weight: normal;
        }

        /* Input Fields Styling for Consistency */
        input, select {
            width: 100%;
            padding: 8px; /* Reduced padding */
            margin-bottom: 12px; /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Submit Button Styling */
        input[type=submit] {
            background-color: #030337;
            color: white;
            border-radius: 4px;
            padding: 8px; /* Reduced padding */
            margin: 15px 0;
            cursor: pointer;
            width: 100%; /* Make the button take the full width */
        }

        /* Reduced Form Box Width */
        .form__box {
            max-width: 600px; /* Limit form width */
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Title Styling */
        h2 {
            text-align: center;
            font-size: 1.4em; /* Slightly smaller title */
            margin-bottom: 20px;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            .form__box {
                width: 100%;
                padding: 15px;
            }

            input, select {
                padding: 10px;
            }
        }
     
		</style>
</head>

<body>
<nav>
<div > <a class="nav__logo" href="index.php">Fast Airlines</a></div>
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

    <div class="form__box" >
    <form action="view_flights_form_handler.php" method="post">
			<h2>SEARCH FOR AVAILABLE FLIGHTS</h2>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Enter the Departure</td>
					<td class="fix_table">Enter the Destination</td>
				</tr>
				<tr>
					<td class="fix_table">
						<input list="origins" name="origin" placeholder="From" required>
  						<datalist id="origins">
  						  	<option value="bangalore">
  						</datalist>
						<!-- <input type="text" name="origin" placeholder="From" required> --></td>
					<td class="fix_table">
						<input list="destinations" name="destination" placeholder="To" required>
  						<datalist id="destinations">
  						  	<option value="mumbai">
  						  	<option value="mysore">
  						  	<option value="mangalore">
  						  	<option value="chennai">
  						  	<option value="hyderabad">
  						</datalist>
						<!-- <input type="text" name="destination" placeholder="To" required> --></td>
				</tr>
			</table>
			<br>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Enter the Departure Date</td>
					<td class="fix_table">Enter the No. of Passengers</td>
				</tr>
				<tr>
					<td class="fix_table"><input type="date" name="dep_date" min=
						<?php 
							$todays_date=date('Y-m-d'); 
							echo $todays_date;
						?> 
						max=
						<?php 
							$max_date=date_create(date('Y-m-d'));
							date_add($max_date,date_interval_create_from_date_string("90 days")); 
							echo date_format($max_date,"Y-m-d");
						?> required></td>
					<td class="fix_table"><input type="number" name="no_of_pass" placeholder="Eg. 5" required></td>
				</tr>
			</table>
			<br>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Enter the Class</td>
				</tr>
				<tr>
					<td class="fix_table">
						<select name="class">
  							<option value="economy">Economy</option>
  							<option value="business">Business</option>
  						</select>
  					</td>
				</tr>
			</table>
			<br>
			<input type="submit" value="Search for Available Flights" name="Search">
		</form>
    </div>

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