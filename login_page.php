<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="login.css">
<link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
<title> Fast Airlines </title>
</head>
<body>
  <body>
    <div class="login-page">
      <div class="form">
        <div class="login">
          <div class="login-header">
          <h3><span class="logo">✈︎</span> Fast Airlines</h3>
          <p>Please enter your credentials to login.</p>
          </div>
        </div>
        <form class="login-form" action="login_handler.php" method="POST">
          <input type="text" placeholder="Username" name="username"/>
          <input type="password" placeholder="Password" name="password"/>
          <br>
				<?php
					if(isset($_GET['msg']) && $_GET['msg']=='failed')
					{
						echo "<br>
						<strong style='color:red'>Invalid Username/Password</strong>
						<br><br>";
					}
				?>
          <input type="submit" name="Login" value="Login" style="background-image: linear-gradient(45deg,#3d5cb8,#64748b) ">
          <p class="message">Not registered? <a href="new_user.php">Create an account</a></p>
        </form>
      </div>
    </div>
</body>
</body>
</html>