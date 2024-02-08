<!DOCTYPE html>
<html lang="en">

<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>

<body>

	<section class="">
		<?php
		include 'header.php';
		?>



		<section class="listings sign">
			<div class="wrapper">

				<h2>Signup Here</h2>
				<form method="post">
					<table>
						<tr>
							<td>Full Name:</td>
							<td><input type="text" name="fname" required></td>
						</tr>
						<tr>
							<td>Phone Number:</td>
							<td><input type="text" name="phone" required></td>
						</tr>
						<tr>
							<td>Email Address:</td>
							<td><input type="email" name="email" required></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><input type="text" name="username" required></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="text" name="password" required></td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>
								<select name="gender">
									<option disabled selected>Select Gender</option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Location:</td>
							<td><input type="text" name="location" required></td>
						</tr>
						<tr>
							<td colspan="2"><input class="bttn" type="submit" name="save" value="Submit Details"></td>
						</tr>
					</table>
				</form>
				<?php
				if (isset($_POST['save']))
					include 'includes/config.php';
				$fname = $_POST['fname'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$gender = $_POST['gender'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$location = $_POST['location'];

				$select = "SELECT * FROM client WHERE username = '$username' OR email = '$email' OR phone = '$phone'";
				$result = mysqli_query($conn, $select);

				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					if ($row['username'] == $username) {
						$errorMsg = "Username already taken. Please choose a different username.";
					} elseif ($row['email'] == $email) {
						$errorMsg = "Email address already used for registration. Please use a different email address.";
					} elseif ($row['phone'] == $phone) {
						$errorMsg = "Phone number already used for registration. Please use a different phone number.";
					}

					echo "<script type=\"text/javascript\">
							alert('$errorMsg');
							window.location = \"signup.php\";
						</script>";
				} else {
					$qry = "INSERT INTO client (fname,username,password,gender,email,phone,location)
							VALUES('$fname','$username','$password','$gender','$email','$phone','$location')";
					$result = $conn->query($qry);
					if ($result == TRUE) {
						echo "<script type=\"text/javascript\">
								alert(\"Successfully Registered.\");
								window.location = \"account.php\";
							</script>";
					}
				}


				?>
				</ul>
			</div>
		</section> <!--  end listing section  -->

</body>
<?php
include 'footer.php';
?>

</html>