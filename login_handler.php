<html>
<head>
    <title>Login Handler</title>
</head>
<body>
    <?php
    session_start();
    session_destroy();
    session_start();

    if (isset($_POST['Login'])) {
        $data_missing = array();

        // Validate username
        if (empty($_POST['username'])) {
            $data_missing[] = 'Username';
        } else {
            $user_name = trim($_POST['username']);
        }

        // Validate password
        if (empty($_POST['password'])) {
            $data_missing[] = 'Password';
        } else {
            $pass_word = $_POST['password'];
        }

        // Proceed with login check only if no missing data
        if (empty($data_missing)) {
            require_once('Database Connection file/mysqli_connect.php');

            // Check in Customer table
            $customer_query = "SELECT count(*) FROM Customer WHERE Customer_id=? AND Password=?";
            $stmt = mysqli_prepare($dbc, $customer_query);
            mysqli_stmt_bind_param($stmt, "ss", $user_name, $pass_word);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $customer_cnt);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Check in Admin table
            $admin_query = "SELECT count(*) FROM admin WHERE admin_id=? AND password=?";
            $stmt = mysqli_prepare($dbc, $admin_query);
            mysqli_stmt_bind_param($stmt, "ss", $user_name, $pass_word);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $admin_cnt);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            mysqli_close($dbc);

            // Redirect based on role
            if ($customer_cnt == 1) {
                echo "Customer logged in <br>";
                $_SESSION['login_user'] = $user_name;
                echo $_SESSION['login_user'] . " is logged in as Customer";
                header('location: index.php'); // Redirect to customer homepage
                exit; // Prevent further execution
            } elseif ($admin_cnt == 1) {
                echo "Admin logged in <br>";
                $_SESSION['login_user'] = $user_name;
                echo $_SESSION['login_user'] . " is logged in as Admin";
                header('location: admin_homepage.php'); // Redirect to admin homepage
                exit; // Prevent further execution
            } else {
                echo "Login Error";
                session_destroy();
                header('location: login_page.php?msg=failed'); // Redirect back to login page
                exit; // Prevent further execution
            }
        } else {
            echo "The following data fields were empty:<br>";
            foreach ($data_missing as $missing) {
                echo $missing . "<br>";
            }
        }
    } else {
        echo "Submit request not received";
    }
    ?>
</body>
</html>
