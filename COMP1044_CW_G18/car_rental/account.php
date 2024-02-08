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
		<section class="banner">
			<section class="midhead">
				<section class="caption">
					<h2>Accompany your journey with <span style="color: white">comfort</span></h2>
					<h3 class="properties">Don't deny yourself the pleasure of driving the best premium cars from around the world here and now.</h3>
				</section>
				<img class="luxcar" src="img/luxcar.png">
			</section>
		</section>
	</section><!--  end hero section  -->


	<section class="search">
		<div class="wrapper">
			<div id="fom">
				<form method="post">
					<h3>Login</h3>
					<table height="100" align="center">
						<tr>
							<td>Username:</td>
							<td><input type="text" name="username" placeholder="Enter Username" required></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="password" placeholder="Enter password" required></td>
						</tr>
						<tr>
							<td><input class="bttn" type="submit" name="log" value="Login"></td>
							<td><a class="bttn" href="signup.php">Signup</a></td>
						</tr>
					</table>
				</form>
				<?php
				if (isset($_POST['log'])) {
					include 'includes/config.php';

					$username = $_POST['username'];
					$password = $_POST['password'];

					$qy = "SELECT * FROM client WHERE username = '$username' AND password = '$password'";
					$log = $conn->query($qy);
					$num = $log->num_rows;
					$row = $log->fetch_assoc();
					if ($num > 0) {
						session_start();
						$_SESSION['username'] = $row['username'];
						$_SESSION['password'] = $row['password'];
						$_SESSION['name'] = $row['fname'];
						echo "<script type = \"text/javascript\">
									alert(\"Login Successful.\");
									window.location = (\"index.php\")
									</script>";
					} else {
						echo "<script type = \"text/javascript\">
									alert(\"Login Failed. Try Again\");
									window.location = (\"account.php\")
									</script>";
					}
				}
				?>
			</div>
		</div>

	</section><!--  end search section  -->

	<?php
	include 'footer.php';
	?>
</body>

</html>