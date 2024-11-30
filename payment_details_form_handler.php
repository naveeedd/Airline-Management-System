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
	</head>
	<body>
		<?php
			if(isset($_POST['Pay_Now']))
			{
				$no_of_pass=$_SESSION['no_of_pass'];
				$flight_no=$_SESSION['flight_no'];
				$journey_date=$_SESSION['journey_date'];
				$class=$_SESSION['class'];
				$pnr=$_SESSION['pnr'];
				$payment_id=$_SESSION['payment_id'];
				$total_amount=$_SESSION['total_amount'];
				$payment_date=$_SESSION['payment_date'];
				$payment_mode=$_POST['payment_mode'];				

				require_once('Database Connection file/mysqli_connect.php');
				if($class=='economy')
				{
					$query="UPDATE Flight_Details SET seats_economy=seats_economy-? WHERE flight_no=? AND departure_date=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"iss",$no_of_pass,$flight_no,$journey_date);
					mysqli_stmt_execute($stmt);
					$affected_rows_1=mysqli_stmt_affected_rows($stmt);
					echo $affected_rows_1.'<br>';
					mysqli_stmt_close($stmt);
				}
				else if($class=='business')
				{
					$query="UPDATE Flight_Details SET seats_business=seats_business-? WHERE flight_no=? AND departure_date=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"iss",$no_of_pass,$flight_no,$journey_date);
					mysqli_stmt_execute($stmt);
					$affected_rows_1=mysqli_stmt_affected_rows($stmt);
					echo $affected_rows_1.'<br>';
					mysqli_stmt_close($stmt);
				}
				// mysqli_stmt_bind_result($stmt,$cnt);
				// mysqli_stmt_fetch($stmt);
				// echo $cnt;
				/*
				$response=@mysqli_query($dbc,$query);
				*/
				if($affected_rows_1==1)
				{
					echo "Successfully Updated Seats<br>";

					$query="INSERT INTO Payment_Details (payment_id,pnr,payment_date,payment_amount,payment_mode) VALUES (?,?,?,?,?)";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"sssis",$payment_id,$pnr,$payment_date,$total_amount,$payment_mode);
					mysqli_stmt_execute($stmt);
					$affected_rows_2=mysqli_stmt_affected_rows($stmt);
					echo $affected_rows_2.'<br>';
					mysqli_stmt_close($stmt);
					if($affected_rows_2==1)
					{
						echo "Successfully Updated Payment Details<br>";
						header('location:ticket_success.php');
					}
					else
					{
						echo "Submit Error";
						echo mysqli_error($connection);
					}
				}
				else
				{
					echo "Submit Error";
					echo mysqli_error($connection);
				}
				mysqli_close($dbc);
			}
			else
			{
				echo "Payment request not received";
			}
		?>
	</body>
</html>