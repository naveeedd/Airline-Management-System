<?php
	session_start();
?>
<html>
	<head>
		<title>Fast Airlines</title>
	</head>
	<body>
		<?php
			if(isset($_POST['Activate']))
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
					$query="UPDATE Jet_Details SET active='Yes' WHERE Aircraft_id=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"s",$jet_id);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					
					mysqli_stmt_close($stmt);
					mysqli_close($dbc);
					
					if($affected_rows==1)
					{
						echo "Successfully Activated";
						header("location: activate_jet_details.php?msg=success");
					}
					else
					{
						echo "Submit Error";
						header("location: activate_jet_details.php?msg=failed");
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
				echo "Activate request not received";
			}
		?>
	</body>
</html>