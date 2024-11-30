<?php
	session_start();
?>
<html>
	<head>
	<link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
	<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="index.css" />
		<title>Fast Airlines</title>
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
    			margin: 0px 68px
			}
      h2 {
            font-size: 28px;
            text-align: center;
            margin-top: 30px;
        }

        h3 {
            font-size: 20px;
            text-align: center;
            margin: 15px auto 30px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin: 20px auto;
        }

        .home-button {
            text-decoration: none;
            background-color: #030337;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #2d4371;
        }

		</style>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        
      


        <div>
        <h2>Your ticket has been cancelled successfully</h2>
        </div>
        <div class="button-container">
    <a class="btn" href="index.php">Back to Homepage</a>
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