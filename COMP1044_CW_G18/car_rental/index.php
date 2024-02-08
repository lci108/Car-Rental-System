<!DOCTYPE html>
<html lang="en">

<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="css/reset.css?">
	<link rel="stylesheet" type="text/css" href="css/responsive.css?">

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


	<section class="listings">
		<div class="wrapper">
			<form class="select">
				<select id="CarTypeSelect" name="car_type">
					<option value="All" <?php if (isset($_GET['car_type']) && $_GET['car_type'] == 'All') echo 'selected'; ?>>All</option>
					<option value="Luxurious" <?php if (isset($_GET['car_type']) && $_GET['car_type'] == 'Luxurious') echo 'selected'; ?>>Luxurious</option>
					<option value="Sports" <?php if (isset($_GET['car_type']) && $_GET['car_type'] == 'Sports') echo 'selected'; ?>>Sports</option>
					<option value="Classics" <?php if (isset($_GET['car_type']) && $_GET['car_type'] == 'Classics') echo 'selected'; ?>>Classics</option>
				</select>
				<button class="bttn" type="submit">Filter</button>
			</form>
			<ul class="properties_list">
				<?php
				include 'includes/config.php';
				$carType = isset($_GET['car_type']) ? $_GET['car_type'] : 'All';
				$sel = "SELECT * FROM cars WHERE status = 'Available'";
				if ($carType != 'All') {
					$sel .= " AND type = '$carType'";
				}
				$rs = $conn->query($sel);
				while ($rws = $rs->fetch_assoc()) {
				?>
					<li>
						<a href="book_car.php?id=<?php echo $rws['car_id'] ?>">
							<img class="thumb" src="cars/<?php echo $rws['image']; ?>">
						</a>
						<span class="price"><?php echo 'RM ' . $rws['hire_cost']; ?></span>
						<div class="property_details">
							<h1>
								<a href="book_car.php?id=<?php echo $rws['car_id'] ?>"><?php echo $rws['car_type']; ?></a>
							</h1>
							<h2>Car Name/Model: <span class="property_size"><?php echo $rws['car_name']; ?></span></h2>
						</div>
					</li>
				<?php
				}
				?>
			</ul>
		</div>
	</section> <!--  end listing section -->



	<?php
	include 'footer.php';
	?>

</body>

</html>