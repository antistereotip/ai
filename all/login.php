<!DOCTYPE html>
<html>
<head>
    <title>Prijava</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h1>Prijava</h1>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Postavljanje MySQL konekcije (pretpostavljamo da već imate bazu podataka postavljenu)
    $conn = new mysqli("localhost", "root", "", "all");

    // Provjera konekcije
    if ($conn->connect_error) {
        die("Konekcija nije uspjela: " . $conn->connect_error);
    }

    // Provjera korisničkih podataka
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username FROM korisnici WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: welcome.php");
    } else {
        echo "Pogrešno korisničko ime ili lozinka.";
    }

    $conn->close();
}
?>

<form action="login.php" method="post">
    Korisničko ime: <input type="text" name="username"><br>
    Lozinka: <input type="password" name="password"><br>
    <input type="submit" value="Prijavi se">
</form>

</body>
</html>
