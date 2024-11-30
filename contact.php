<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32"/>
    <title>Fast Airlines</title>
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
  <div>
    <section class="section__container travellers__container">
        <h2 class="section__header" style="margin-top: -30px; padding:0">Contact our Developers</h2>
        <div class="developers__grid" style="margin: 20px; padding:0">
            <div class="travellers__card">
                <img src="assets/naveed.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <h4>Naveed Raza</h4>
                    <p>Front-end Developer</p>
                    <p>naveedraza2003@gmail.com</p>
                </div>
            </div>
            <div class="travellers__card">
                <img src="assets/faiq.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <h4>Faiq Ahmed Khan</h4>
                    <p>Back-end Developer</p>
                    <p>faiqahmedkhan@gmail.com</p>
                </div>
            </div>
    </section>
  </div>
    <div>
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
    </div>
</body>

</html>