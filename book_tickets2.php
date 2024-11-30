<?php
	session_start();
?>
<html>
	<head>
  <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
		<title>Fast Airlines</title>
		<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: white;
        }
        .container{
          margin:30px;
        }

        .form-container {
            max-width: 800px;
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 ,p{
            margin-top:30px;
            margin-left: 10px;
            color: black;
        }

        table {
            margin-left: 10px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1.5px solid #030337;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: #3d5cb8;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #2d4371;
        }

        input[type=radio] {
            margin-right: 5px;
        }
		</style>
          <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
        <link rel="stylesheet" href="index.css" />
        <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
	</head>
	<body>
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
  <div class="container">
		<?php
			$no_of_pass=$_SESSION['no_of_pass'];
			$class=$_SESSION['class'];
			$count=$_SESSION['count'];
			$flight_no=$_POST['select_flight'];
			$_SESSION['flight_no']=$flight_no;
			//$pass_name=array();
			echo "<h2>ADD PASSENGERS DETAILS</h2>";
			echo "<form action=\"add_ticket_details_form_handler.php\" method=\"post\">";
			while($count<=$no_of_pass)
			{
					echo "<p><strong>PASSENGER ".$count."<strong></p>";
					echo "<table cellpadding=\"0\">";
					echo "<tr>";
					echo "<td class=\"fix_table_short\">Passenger's Name</td>";
					echo "<td class=\"fix_table_short\">Passenger's Age</td>";
					echo "<td class=\"fix_table_short\">Passenger's Gender</td>";
					echo "<td class=\"fix_table_short\">Passenger's Inflight Meal</td>";
					echo "<td class=\"fix_table_short\">Passenger's Frequent Flier ID (if applicable)</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td class=\"fix_table_short\"><input type=\"text\" name=\"pass_name[]\" required></td>";
					echo "<td class=\"fix_table_short\"><input type=\"number\" name=\"pass_age[]\" required></td>";
					echo "<td class=\"fix_table_short\">";
					echo "<select name=\"pass_gender[]\">";
  					echo "<option value=\"male\">Male</option>";
  					echo "<option value=\"female\">Female</option>";
  					echo "<option value=\"other\">Other</option>";
  					echo "</select>";
  					echo "</td>";
  					echo "<td class=\"fix_table_short\">";
					echo "<select name=\"pass_meal[]\">";
  					echo "<option value=\"yes\">Yes</option>";
  					echo "<option value=\"no\">No</option>";
  					echo "</select>";
  					echo "</td>";
  					echo "<td class=\"fix_table_short\"><input type=\"text\" name=\"pass_ff_id[]\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr>";
					$count=$count+1;
				}
				echo "<br><h2>ENTER TRAVEL DETAILS</h2>";
				echo "<table cellpadding=\"5\">";
				echo "<tr>";
				echo "<td class=\"fix_table_short\">Do you want access to our Premium Lounge?</td>";
				echo "<td class=\"fix_table_short\">Do you want to opt for Priority Checkin?</td>";
				echo "<td class=\"fix_table_short\">Do you want to purchase Travel Insurance?</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class=\"fix_table\">";
				echo "Yes <input type='radio' name='lounge_access' value='yes' checked/> No <input type='radio' name='lounge_access' value='no'/>";
  				echo "</td>";
  				echo "<td class=\"fix_table\">";
				echo "Yes <input type='radio' name='priority_checkin' value='yes' checked/> No <input type='radio' name='priority_checkin' value='no'/>";
  				echo "</td>";
  				echo "<td class=\"fix_table\">";
				echo "Yes <input type='radio' name='insurance' value='yes' checked/> No <input type='radio' name='insurance' value='no'/>";
  				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "<br><br>";
				echo "<input type=\"submit\" value=\"Submit Travel/Ticket Details\" name=\"Submit\">";
				echo "</form>";
		?>
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