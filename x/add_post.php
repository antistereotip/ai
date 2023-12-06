<?php
require_once('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST["naslov"];
    $sadrzaj = $_POST["sadrzaj"];
    $datum = $_POST["datum"];
    $autor = $_POST["autor"];
    $korisnik_id = $_SESSION['korisnik_id'];

    // Spremi sliku u folder "uploads"
    $uploadsFolder = "uploads/";
    $slikaName = $_FILES["slika"]["name"];
    $slikaPath = $uploadsFolder . $slikaName;
    move_uploaded_file($_FILES["slika"]["tmp_name"], $slikaPath);

    $sql = "INSERT INTO postovi (naslov, slika, sadrzaj, datum, autor, korisnik_id) VALUES ('$naslov', '$slikaPath', '$sadrzaj', '$datum', '$autor', '$korisnik_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Uspješno ste dodali post.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
