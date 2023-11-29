<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h1>Dobrodošli na r00tX</h1>

<?php
session_start();

if(isset($_SESSION['user_id'])) {
    echo '<p>Prijavljeni ste kao ' . $_SESSION['username'] . '. <a href="welcome.php">Pogledajte vaš prostor</a> ili idite na <a href="master.php">Wall</a></p>';
} else {
    echo '<p><a href="login.php">Prijavite se</a> da biste stvorili ili pregledali vaš blog.</p>';
}

?>

</body>
</html>
