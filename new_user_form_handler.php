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
			if(isset($_POST['Submit']))
			{
				$data_missing=array();
				if(empty($_POST['username']))
				{
					$data_missing[]='User Name';
				}
				else
				{
					$user_name=trim($_POST['username']);
				}
				if(empty($_POST['password']))
				{
					$data_missing[]='Password';
				}
				else
				{
					$password=$_POST['password'];
				}
				if(empty($_POST['email']))
				{
					$data_missing[]='Email ID';
				}
				else
				{
					$email_id=trim($_POST['email']);
				}

				if(empty($_POST['name']))
				{
					$data_missing[]='Name';
				}
				else
				{
					$name=$_POST['name'];
				}
				if(empty($_POST['phone_no']))
				{
					$data_missing[]='Phone No.';
				}
				else
				{
					$phone_no=trim($_POST['phone_no']);
				}
				if(empty($_POST['address']))
				{
					$data_missing[]='Address';
				}
				else
				{
					$address=$_POST['address'];
				}

				if(empty($data_missing))
				{
					require_once('Database Connection file/mysqli_connect.php');
					$query="INSERT INTO Customer (Customer_id,Password,Name,Email,Phone_no,Address) VALUES (?,?,?,?,?,?)";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ssssss",$user_name,$password,$name,$email_id,$phone_no,$address);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					
					mysqli_stmt_close($stmt);
					mysqli_close($dbc);
					
					if($affected_rows==1)
					{
						header('location:user_reg_success.php');
					}
					else
					{
						echo "Submit Error";
						echo mysqli_error($connection);
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
				echo "Submit request not received";
			}
		?>
	</body>
</html>