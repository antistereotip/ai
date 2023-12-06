<?php
require_once('db_connection.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST["korisnicko_ime"];
    $lozinka = $_POST["lozinka"];

    $sql = "SELECT * FROM korisnici WHERE korisnicko_ime='$korisnicko_ime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($lozinka, $row["lozinka"])) {
            $_SESSION['korisnik_id'] = $row['id'];
            $_SESSION['korisnicko_ime'] = $row['korisnicko_ime'];
            echo "Uspešna prijava.";
            // Možete preusmjeriti korisnika na drugu stranicu nakon prijave
            header('Location: welcome.php');
        } else {
            echo "Pogrešna lozinka.";
        }
    } else {
        echo "Korisnik nije pronađen.";
    }
}

$conn->close();
?>
