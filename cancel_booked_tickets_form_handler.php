<?php
session_start();
?>
<html>
	<head>
	<link rel="icon" type="image/png" href="assets/icon.png" sizes="32x32" />
		<title>
			Fast Airlines
		</title>
	</head>
	<body>
		<?php
			if(isset($_POST['Cancel_Ticket']))
			{
				$data_missing=array();
				if(empty($_POST['pnr']))
				{
					$data_missing[]='PNR';
				}
				else
				{
					$pnr=trim($_POST['pnr']);
				}

				if(empty($data_missing))
				{
					require_once('Database Connection file/mysqli_connect.php');

					$todays_date=date('Y-m-d'); 
					$customer_id=$_SESSION['login_user'];

					$query="SELECT count(*) from Ticket_Details t WHERE pnr=? and journey_date>=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ss",$pnr,$todays_date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$cnt);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);
					if($cnt!=1)
					{
						mysqli_close($dbc);
						header("location: cancel.php?msg=failed");
						exit(); // Exit the script to prevent further execution
					}

					$query="UPDATE Ticket_Details SET booking_status='CANCELED' WHERE pnr=? and Customer_id=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ss",$pnr,$customer_id);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					mysqli_stmt_close($stmt);
					if($affected_rows==1)
					{
						$query="SELECT t.flight_no,t.journey_date,t.no_of_passengers,t.class,0.85*p.payment_amount as refund_amount from Ticket_Details t,Payment_Details p WHERE t.pnr=? and t.pnr=p.pnr";
						$stmt=mysqli_prepare($dbc,$query);
						mysqli_stmt_bind_param($stmt,"s",$pnr);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$flight_no,$journey_date,$no_of_pass,$class,$refund_amount);
						mysqli_stmt_fetch($stmt);
						mysqli_stmt_close($stmt);
						$_SESSION['refund_amount']=$refund_amount;

						$affected_rows_1 = 0; // Initialize the variable

						if($class=='economy')
						{
							$query="UPDATE Flight_Details SET seats_economy=seats_economy+? WHERE flight_no=? AND departure_date=?";
							$stmt=mysqli_prepare($dbc,$query);
							mysqli_stmt_bind_param($stmt,"iss",$no_of_pass,$flight_no,$journey_date);
							mysqli_stmt_execute($stmt);
							$affected_rows_1=mysqli_stmt_affected_rows($stmt);
							mysqli_stmt_close($stmt);
						}
						else if($class=='business')
						{
							$query="UPDATE Flight_Details SET seats_business=seats_business+? WHERE flight_no=? AND departure_date=?";
							$stmt=mysqli_prepare($dbc,$query);
							mysqli_stmt_bind_param($stmt,"iss",$no_of_pass,$flight_no,$journey_date);
							mysqli_stmt_execute($stmt);
							$affected_rows_1=mysqli_stmt_affected_rows($stmt);
							mysqli_stmt_close($stmt);
						}

						if($affected_rows_1==1)
						{
							header("location: cancel_booked_tickets_success.php");
							exit(); // Exit the script to prevent further execution
						}
						else
						{
							echo "Submit Error";
							echo mysqli_error($dbc);
						}
					}
					else
					{
						echo "Submit Error";
						echo mysqli_error($dbc);
						header("location: cancel.php?msg=failed");
						exit(); // Exit the script to prevent further execution
					}

					mysqli_close($dbc);
				}
				else
				{
					echo "The following data fields were empty! <br>";
					foreach($data_missing as $missing)
					{
						echo $missing ."<br>";
					}
				}
			}
			else
			{
				echo "Cancel request not received";
			}
		?>
	</body>
</html>
