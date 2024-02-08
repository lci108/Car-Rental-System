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
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

	<section class="">
		<?php
		include 'header.php';
		?>
	</section><!--  end hero section  -->

	<section class="listings">
		<div class="wrapper">
			<ul class="properties_list">
				<?php
				include 'includes/config.php';
				$sel = "SELECT * FROM cars WHERE car_id = '$_GET[id]'";
				$rs = $conn->query($sel);
				$rws = $rs->fetch_assoc();
				?>
				<li>
					<a href="book_car.php?id=<?php echo $rws['car_id'] ?>">
						<img class="thumb" src="cars/<?php echo $rws['image']; ?>" width="300" height="200">
					</a>
					<span class="price"><?php echo 'RM ' . $rws['hire_cost']; ?></span>
					<div class="property_details">
						<h1>
							<a href="book_car.php?id=<?php echo $rws['car_id'] ?>"><?php echo $rws['car_type']; ?></a>
						</h1>
						<h2>Car Name/Model: <span class="property_size"><?php echo $rws['car_name']; ?></span></h2>
					</div>
				</li>
				<section class="book">
					<h2 class="adv">Unlock your next adventure with our wheels</h2>
					<h3>Proceed to Hire <?php echo $rws['car_name']; ?>. </h3>
					<?php
					if ($_SESSION['username'] && ($_SESSION['password'])) {
					?>
						<?php
						require('includes/config.php');

						$CarID = $rws['car_id'];

						// Retrieve the car information from the database
						$query_car = "SELECT * FROM cars WHERE car_id = '$CarID'";
						$result_car = mysqli_query($conn, $query_car);
						$row_car = mysqli_fetch_array($result_car);


						// Get all existing reservations for the selected car
						$query_reservations = "SELECT start_date, end_date FROM reservation WHERE car_id = '$CarID'";
						$result_reservations = mysqli_query($conn, $query_reservations);
						$reservations = array();
						while ($row_reservations = mysqli_fetch_array($result_reservations)) {
							$start = new DateTime($row_reservations['start_date']);
							$end = new DateTime($row_reservations['end_date']);
							$end->modify('+1 day'); // add one more day to the rental end date
							$reservations[] = array(
								'start' => $start->format('m/d/Y'),
								'end' => $end->format('m/d/Y')
							);
						}


						mysqli_close($conn);
						?>
						<form method="post">
							<label for="reservation_id">Booking Number:</label>
							<input type="text" id="reservation_id" name="reservation_id" value="<?php echo uniqid(); ?>" readonly><br>
							<label for="customer_name">Customer Name :</label>
							<input type="text" id="customer_name" name="customer_name"><br>
							<label for="reservationdate">Reservation Date :</label>
							<input type="text" name="daterange" value="01/01/2023 - 01/15/2023" /><br>

							<script>
								$(function() {

									var existingReservations = <?php echo json_encode($reservations); ?>;
									var disabledDates = [];
									for (var i = 0; i < existingReservations.length; i++) {
										var start = moment(existingReservations[i].start);
										var end = moment(existingReservations[i].end);
										var duration = moment.duration(end.diff(start)).asDays();
										for (var j = 0; j < duration; j++) {
											var date = start.clone().add(j, 'days');
											disabledDates.push(date.format('MM/DD/YYYY'));
										}
									}


									$('input[name="daterange"]').daterangepicker({
										startDate: moment(),
										minDate: moment(),
										opens: 'left',
										isInvalidDate: function(date) {
											return (disabledDates.indexOf(date.format('MM/DD/YYYY')) !== -1 || date.isBefore(moment().startOf('day')));
										}
									}, function(start, end, label) {
										var rentalstartdate = start.format('YYYY-MM-DD');
										var rentalenddate = end.format('YYYY-MM-DD');
										console.log("A new date selection was made: " + rentalstartdate + ' to ' + rentalenddate);
									});
								});
							</script>
							<script>
								$(function() {
									$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
										// Calculate the number of days and the total fee
										var start = moment(picker.startDate);
										var end = moment(picker.endDate);
										var duration = end.diff(start, 'days') + 1;
										var hire_cost = <?php echo $row_car['hire_cost']; ?>;
										var totalfee = hire_cost * duration;

										// Set the values of the number of days and the total fee inputs

										$('input[name="numdays"]').val(duration);
										$('input[name="Totalfee"]').val(totalfee);
									});
								});
							</script>
							<label for="numdays">Number of Day(s) :</label>
							<input type="text" id="numdays" name="numdays" value="0" readonly><br>
							<label for="totalfee">Total Fee (RM) : </label>
							<input type="text" id="totalfee" name="Totalfee" value="0.00" readonly><br>

							<td colspan="2"><input class="bttnn bttn" type="submit" name="save" value="Submit Details"></td>
							</tr>
							</table>
						</form>

						<?php
						if (isset($_POST['save'])) {
							include 'includes/config.php';
							$CarID = $CarID;
							$Totalfee = $_POST['Totalfee'];
							$daterange = $_POST['daterange'];
							$customer_name = $_POST['customer_name'];
							$reservation_id = $_POST['reservation_id'];
							if ($Totalfee > 0) {
								$daterange_arr = explode(" - ", $daterange);
								$rentalstartdate = date("Y-m-d", strtotime($daterange_arr[0]));
								$rentalenddate = date("Y-m-d", strtotime($daterange_arr[1]));

								$qry = "INSERT INTO reservation (reservation_id,customer_name,car_id,start_date,end_date,fees)
								VALUES('$reservation_id','$customer_name','$CarID','$rentalstartdate','$rentalenddate','$Totalfee')";
								$result = $conn->query($qry);
								if ($result == TRUE) {
									echo "<script type = \"text/javascript\">
												alert(\"Successfully Reserved. Proceed to see details\");
												window.location = (\"book_details.php?customer_name=$customer_name&car_id=$CarID&start_date=$rentalstartdate&end_date=$rentalenddate&fees=$Totalfee\")
												</script>";
								} else {
									echo "<script type = \"text/javascript\">
												alert(\"Reservation Failed. Try Again\");
												window.location = (\"index.php\")
												</script>";
								}
							} else {
								echo "<script type = \"text/javascript\">
												alert(\"Reservation Failed. Please select at least one day of booking\");
												window.location = (\"index.php\")
												</script>";
							}
						}


						?>
					<?php
					} else {
					?>
						<a class="bttn" href="account.php">Login</a>
					<?php
					}
					?>
				</section>


			</ul>
		</div>
	</section> <!--  end listing section  -->

	<?php
	include 'footer.php';
	?>

</body>

</html>