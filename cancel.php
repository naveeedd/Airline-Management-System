<?php
	session_start();
?>
<html>
	<head>
		<title>
			Cancel Booked Tickets
		</title>
            <style>
           body{
            margin: 0;
            padding: 0;
           }
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
    			margin: 0px 68px
			}
		</style>
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    	integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    	<link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    	<link rel="stylesheet" href="index.css" />
    	<link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
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
		<form class="row g-3" action="cancel_booked_tickets_form_handler.php" method="post">
			<?php
				if(isset($_GET['msg']) && $_GET['msg']=='failed')
				{
					echo "<strong style='color: red'>*Invalid PNR, please enter PNR again</strong>
						<br>
						<br>";
				}
			?>
			<div class="col-md-6">
                <label for="fname" class="form-label">Enter PNR</label>
                <input type="text" name="pnr" class="form-control" required>
            </div>
			<br>
			<div class="col-12" style="margin-bottom: 100px">
                <button type="submit" name= "Cancel_Ticket" value="Cancel Ticket" class="btn btn-primary">Search</button>
            </div>
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