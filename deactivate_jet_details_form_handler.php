<?php
	session_start();
?>
<html>
	<head>
		<title>Deactivate Aircraft</title>
	</head>
	<body>
		<?php
			if(isset($_POST['Deactivate']))
			{
				$data_missing=array();
				if(empty($_POST['jet_id']))
				{
					$data_missing[]='Jet ID';
				}
				else
				{
					$jet_id=trim($_POST['jet_id']);
				}

				if(empty($data_missing))
				{
					require_once('Database Connection file/mysqli_connect.php');
					$query="UPDATE Jet_Details SET active='No' WHERE Aircraft_id=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"s",$jet_id);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					
					mysqli_stmt_close($stmt);
					mysqli_close($dbc);
					
					if($affected_rows==1)
					{
						echo "Successfully Deactvated";
						header("location: deactivate_jet_details.php?msg=success");
					}
					else
					{
						echo "Submit Error";
						header("location: deactivate_jet_details.php?msg=failed");
					}
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
				echo "Deactivate request not received";
			}
		?>
	</body>
</html>