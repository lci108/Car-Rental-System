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
	</section><!--  end hero section  -->

	<section class="listings change">
		<div class="wrapper">
			<ul class="properties_list">
				<?php
				include 'includes/config.php';
				if (isset($_GET['car_id'], $_GET['start_date'], $_GET['end_date'], $_GET['fees'])) {
					$customer_name = $_GET['customer_name'];
					$car_id = $_GET['car_id'];
					$start_date = $_GET['start_date'];
					$end_date = $_GET['end_date'];
					$fees = $_GET['fees'];
				} else {
					echo "Invalid URL";
				}
				?>
				<?php
				include 'includes/config.php';
				$sel = "SELECT * FROM cars WHERE car_id = '$car_id'";
				$rs = $conn->query($sel);
				$rws = $rs->fetch_assoc();
				?>
				<img class="thumb" src="cars/<?php echo $rws['image']; ?>" width="300" height="200"><br>
				<?php
				include 'includes/config.php';

				$qry = "SELECT reservation_id FROM reservation WHERE car_id = '$car_id' AND start_date = '$start_date' AND end_date = '$end_date'";
				$result = $conn->query($qry);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$reservation_id = $row['reservation_id'];
					// display the details of the reserved car
					echo "Customer Name : $customer_name<br>";
					echo "<br>";
					echo "Reservation ID : $reservation_id<br>";
					echo "<br>";
					echo "Rental Start Date: $start_date<br>";
					echo "<br>";
					echo "Rental End Date: $end_date<br>";
					echo "<br>";
					echo "Total Fees: $fees<br>";
				} else {
					echo "Sorry Please Try Again";
				}
				?>


			</ul>
			<div class="more_listing">
				<a href="index.php" class="bttn">Continue to book other cars</a>
			</div>
		</div>
	</section> <!--  end listing section  -->

	<?php
	include 'footer.php';
	?>

</body>

</html>