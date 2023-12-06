<?php
session_start();

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnik_id'])) {
    // Ako korisnik nije prijavljen, preusmjeri ga na stranicu za prijavu
    header('Location: login_form.html');
    exit();
}

// Nastavi sa prikazom posta

require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "SELECT * FROM postovi WHERE id = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $naslov = $row['naslov'];
        $slika = $row['slika'];
        $sadrzaj = $row['sadrzaj'];
        $datum = $row['datum'];
        $autor = $row['autor'];

        // Prikazi informacije o postu
        echo "<h2>$naslov</h2>";
        echo "<p>Datum: $datum</p>";
        echo "<p>Autor: $autor</p>";
        echo "<p>$sadrzaj</p>";
        echo "<img src='$slika' alt='Slika posta'>";
    } else {
        echo "Post nije pronađen.";
    }
} else {
    echo "Nevažeći zahtjev.";
}

$conn->close();
?>
