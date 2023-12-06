<?php
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST["korisnicko_ime"];
    $email = $_POST["email"];
    $lozinka = password_hash($_POST["lozinka"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO korisnici (korisnicko_ime, email, lozinka) VALUES ('$korisnicko_ime', '$email', '$lozinka')";

    if ($conn->query($sql) === TRUE) {
        echo "Uspješno ste registrovani.";

        // Automatska prijava nakon registracije
        session_start();
        $_SESSION['korisnik_id'] = $conn->insert_id;
        $_SESSION['korisnicko_ime'] = $korisnicko_ime;

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
