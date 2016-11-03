<?php
include_once 'db_connect.php';
include_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<div class="banner">
	<object type="image/svg+xml" data="banner.svg">Your browser does not support SVG</object>
</div>
<div class="navbar">
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="shop.php">Shop</a></li>
		<li><a href="profile.php">Profile</a></li>
		<li><a href="contact.php">Contact</a></li>
		<?php if (!isset($_SESSION["user_id"] )):	?>
			<li><a href="login.php">Login</a></li>
		<?php else: ?>
			<li><a href="includes/logout.php">Logout</a></li>
			<li class="float_right"><?php echo "Wellcome " . GetFullName($mysqli, $_SESSION["user_id"] ); ?></li>
		<?php endif; ?>
	</ul>
</div>
