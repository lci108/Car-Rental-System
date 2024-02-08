<!DOCTYPE html>
<html lang="en">

<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<style type="text/css">
		.status {
			font-size: 20px;
		}
	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>

<body>

	<section class="">
		<?php
		include 'header.php';
		?>
	</section><!--  end hero section  -->


	<section class="listings display">
		<div class="wrapper">
			<h2>Enter your Reservation ID</h2>
			<form method="post">
				<h3 style="text-align:center; color: #000099; font-weight:bold; text-decoration:underline"></h3>
				<table height="100" align="center">
					<tr>
						<td>Reservation ID:</td>
						<td><input type="text" name="reservation_id" placeholder="Reservation ID" required></td>
					</tr>
					<td colspan="2"><input class="bttn" type="submit" name="confirm" value="Confirm"></td>
					</tr>
				</table>
			</form>
		</div>
		<?php
		if (isset($_POST['confirm'])) {
			include 'includes/config.php';

			$ID = $_POST['reservation_id'];

			$query = "SELECT * FROM reservation WHERE reservation_id = '$ID'";
			$rs = $conn->query($query);
			$num = $rs->num_rows;
			$rows = $rs->fetch_assoc();
			if ($num > 0) {
				echo "<script type = \"text/javascript\">
									alert(\"Enter your details to update..\");
									window.location = (\"update_details.php?id=" . urlencode($ID) . "\")
									</script>";
			} else {
				echo "<script type = \"text/javascript\">
									alert(\"Invalid Reservation ID\");
									window.location = (\"status.php\")
									</script>";
			}
		}
		?>
	</section> <!--  end listing section  -->

	<?php
	include 'footer.php';
	?>

</body>

</html>