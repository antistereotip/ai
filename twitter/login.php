<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM korisnici WHERE korisnicko_ime = '$username' AND lozinka = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
    } else {
        echo "Pogrešno korisničko ime ili lozinka.";
    }
}
?>
