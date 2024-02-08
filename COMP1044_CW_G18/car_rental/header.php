<?php
session_start();
error_reporting(E_NOTICE);
?>
<header>
	<div class="wrapper">
		<img class="logo" src="img/black.png" width="20%" height="20%">
		<nav>
			<?php
			if (!$_SESSION['username'] && (!$_SESSION['password'])) {
			?>
				<ul>
					<li><a href="index.php">Home</a></li>

					<li><a href="account.php">Login</a></li>
				</ul>
			<?php
			} else {
			?>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="status.php">Change/Update</a></li>
					<li><a href="display_reservation.php">Reservations</a></li>
					<li><a href="logout.php">Logout</a></li>
					<li class="welcname">WELCOME, <?php echo strtoupper($_SESSION['name']); ?></li>

				</ul>

			<?php
			}
			?>
		</nav>

	</div>
</header>