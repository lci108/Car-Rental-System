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

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
            <h2 style=>Car Rental Admin Panel</h2>

            <body>
                <h3>Reservation Details</h3>
                <table class="res">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Reservation ID</th>
                            <th>Car ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Fees</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/config.php';
                        $sql = "SELECT customer_name, reservation_id, car_id, start_date, end_date, fees FROM reservation";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['customer_name'] . "</td>";
                                echo "<td>" . $row['reservation_id'] . "</td>";
                                echo "<td>" . $row['car_id'] . "</td>";
                                echo "<td>" . $row['start_date'] . "</td>";
                                echo "<td>" . $row['end_date'] . "</td>";
                                echo "<td>" . $row['fees'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No reservations found</td></tr>";
                        }
                        $conn->close();

                        ?>
                    </tbody>
                </table>
            </body>



    </section> <!--  end listing section  -->

    <?php
    include 'footer.php';
    ?>

</body>

</html>