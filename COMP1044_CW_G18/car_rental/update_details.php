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


    <section class="listings change display">
        <div class="wrapper">
            <h2>Existing Details</h2>

            <?php
            include 'includes/config.php';
            $sel = "SELECT * FROM reservation WHERE reservation_id = '$_GET[id]'";
            $rs = $conn->query($sel);
            $rws = $rs->fetch_assoc();
            $CarID = $rws['car_id'];
            echo "Rental Start Date: {$rws['start_date']}<br>";
            echo "<br>";
            echo "Rental End Date: {$rws['end_date']}<br>";
            echo "<br>";
            echo "Total Fees: {$rws['fees']}<br>";
            echo "<br>";
            ?>
            <?php
            include 'includes/config.php';
            $sel = "SELECT * FROM cars WHERE car_id = '$CarID'";
            $rs = $conn->query($sel);
            $rws = $rs->fetch_assoc();
            ?>
            <img class="thumb" src="cars/<?php echo $rws['image']; ?>" width="300" height="200"><br>

            <h2>Update New Reservation</h2>

            <h3 style="text-align:center; color: #000099; font-weight:bold; text-decoration:underline"></h3>
            <table align="center">
                <tr>
                    <?php
                    require('includes/config.php');

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
                        <label for="reservationdate">New Reservation Date :</label>
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

                        <button class="bttn bres" type="submit" name="save">Update Reservation</button>

                        <!--  Delete Reservation -->
                        <h2>Delete Reservation</h2>
                        <button class="bttn" type="submit" name="delete">Delete Reservation</button>

            </table>
            <?php
            if (isset($_POST['save'])) {
                // Handle reservation update
                include 'includes/config.php';
                $reservation_id = $_GET['id'];
                $Totalfee = $_POST['Totalfee'];
                $daterange = $_POST['daterange'];
                if ($Totalfee > 0) {
                    $daterange_arr = explode(" - ", $daterange);
                    $rentalstartdate = date("Y-m-d", strtotime($daterange_arr[0]));
                    $rentalenddate = date("Y-m-d", strtotime($daterange_arr[1]));

                    $qry = "UPDATE reservation SET start_date='$rentalstartdate', end_date='$rentalenddate', fees='$Totalfee' WHERE reservation_id='$reservation_id'";
                    $result = $conn->query($qry);
                    if ($result == TRUE) {
                        echo "<script type=\"text/javascript\">
                        alert(\"Successfully Reserved. Proceed to see details\");
                        window.location = (\"display_reservation.php\")
                    </script>";
                    } else {
                        echo "<script type=\"text/javascript\">
                        alert(\"Reservation Failed. Try Again\");
                        window.location = (\"#?car_id=$CarID&start_date=$rentalstartdate&end_date=$rentalenddate&fees=$Totalfee\")
                    </script>";
                    }
                } else {
                    echo "<script type=\"text/javascript\">
                        alert(\"Reservation Failed. Please select at least one day of booking\");
                        window.location = (\"#?car_id=$CarID&start_date=$rentalstartdate&end_date=$rentalenddate&fees=$Totalfee\")
                    </script>";
                }
            } elseif (isset($_POST['delete'])) {
                // Handle reservation deletion
                include 'includes/config.php';
                $reservation_id = $_GET['id'];
                $qry = "DELETE FROM reservation WHERE reservation_id='$reservation_id'";
                $result = $conn->query($qry);
                if ($result == TRUE) {
                    echo "<script type=\"text/javascript\">
                            alert(\"Successfully deleted reservation\");
                            window.location = (\"display_reservation.php\")
                        </script>";
                } else {
                    echo "<script type=\"text/javascript\">
                            alert(\"Failed to delete reservation\");
                            window.location = (\"#?car_id=$CarID&start_date=$rentalstartdate&end_date=$rentalenddate&fees=$Totalfee\")
                        </script>";
                }
            }
            ?>






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
									window.location = (\"update_details.php\")
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