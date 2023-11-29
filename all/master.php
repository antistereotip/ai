<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Postavljanje MySQL konekcije
$conn = new mysqli("localhost", "root", "", "all");

// Provjera konekcije
if ($conn->connect_error) {
    die("Konekcija nije uspjela: " . $conn->connect_error);
}

// Postavljanje paginacije
$stavke_po_stranici = 5;
$stranica = isset($_GET['stranica']) ? $_GET['stranica'] : 1;
$limit = ($stranica - 1) * $stavke_po_stranici;

// Dohvat ukupnog broja blog postova
$sql_count = "SELECT COUNT(id) AS ukupno FROM blog_postovi";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$ukupno_stavki = $row_count['ukupno'];

// Dohvat blog postova sa paginacijom
$sql_select = "SELECT id, naslov, sadrzaj, slika, datum_objave, autor_id, autor_username FROM blog_postovi LIMIT $limit, $stavke_po_stranici";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Svi Blog Postovi</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">

    <h1>Svi Blog Postovi</h1>
    <h2>Vrati se na <a href="welcome.php">welcome stranicu</a></h2>
    <!-- Prikaz svih blog postova -->
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h2>{$row['naslov']}</h2>";
            echo "<p>{$row['sadrzaj']}</p>";

            // Prikaz slike ako postoji
            if (!empty($row['slika'])) {
                echo "<img src='{$row['slika']}' alt='Slika' width='200'>";
            }

            echo "<p class='post-date'>Datum objave: {$row['datum_objave']}</p>";
            echo "<p class='post-author'>Autor: {$row['autor_username']}</p>";

            echo "</div>";
        }
    } else {
        echo "<p>Nema dostupnih blog postova.</p>";
    }

    // Paginacija
    $ukupno_stranica = ceil($ukupno_stavki / $stavke_po_stranici);
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $ukupno_stranica; $i++) {
        echo "<a href='master.php?stranica=$i' ";
        if ($i == $stranica) {
            echo "class='active'";
        }
        echo ">$i</a>";
    }
    echo "</div>";
    ?>

    <p><a href="index.php">Povratak na Početnu stranicu</a></p>

</div>

</body>
</html>
