<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
    <title>Fast Airlines</title>
</head>
<body>

    <div class="login-page">
        <div class="form">
            <div class="login-header">
                <h3><span class="logo">✈︎</span>Fast Airlines</h3>
                <p>Sign up to join us and experience seamless travel!</p>
            </div>

            <form class="login-form" action="new_user_form_handler.php" method="POST" id="new_user_form">
                <input type="text" placeholder="Username" name="username" required />
                <input type="password" placeholder="Set Password" name="password" required />
                <input type="email" placeholder="Email Address" name="email" required />
                <input type="text" placeholder="Full Name" name="name" required />
                <input type="text" placeholder="Phone Number" name="phone_no" required />
                <input type="text" placeholder="Address" name="address" required />
                <input type="submit" name="Submit" value="Sign Up" />
            </form>

            <p class="message">Already have an account? <a href="login_page.php">Login</a></p>
        </div>
    </div>

</body>
</html>
