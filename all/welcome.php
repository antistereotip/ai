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

// Provjera ako je obrazac za dodavanje, izmenu ili brisanje blog posta poslan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_post'])) {
        // Brisanje blog posta
        $post_id = $_POST['post_id'];
        $sql_delete = "DELETE FROM blog_postovi WHERE id = '$post_id' AND autor_id = " . $_SESSION['user_id'];
        if ($conn->query($sql_delete) === TRUE) {
            echo '<div class="success-message">Blog post je uspešno obrisan.</div>';
        } else {
            echo '<div class="error-message">Greška pri brisanju blog posta: ' . $conn->error . '</div>';
        }
    } elseif (isset($_POST['update_post'])) {
        // Izmena blog posta
        $post_id = $_POST['post_id'];
        $naslov = $_POST['naslov'];
        $sadrzaj = $_POST['sadrzaj'];

        // Obrada upload-a nove slike
        $nova_slika_path = null;
        if (isset($_FILES['nova_slika']) && $_FILES['nova_slika']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $nova_uploaded_file = $upload_dir . basename($_FILES['nova_slika']['name']);
            move_uploaded_file($_FILES['nova_slika']['tmp_name'], $nova_uploaded_file);
            $nova_slika_path = $nova_uploaded_file;
        }

        // Ako postoji nova slika, ažuriraj putanju slike
        if (!empty($nova_slika_path)) {
            $sql_update = "UPDATE blog_postovi SET naslov = '$naslov', sadrzaj = '$sadrzaj', slika = '$nova_slika_path' WHERE id = '$post_id' AND autor_id = " . $_SESSION['user_id'];
        } else {
            $sql_update = "UPDATE blog_postovi SET naslov = '$naslov', sadrzaj = '$sadrzaj' WHERE id = '$post_id' AND autor_id = " . $_SESSION['user_id'];
        }

        if ($conn->query($sql_update) === TRUE) {
            echo '<div class="success-message">Blog post je uspešno izmenjen.</div>';
        } else {
            echo '<div class="error-message">Greška pri izmeni blog posta: ' . $conn->error . '</div>';
        }
    } else {
        // Dodavanje novog blog posta
        $naslov = $_POST['naslov'];
        $sadrzaj = $_POST['sadrzaj'];
        $autor_id = $_SESSION['user_id'];

        // Obrada upload-a slike
        $slika_path = null;
        if (isset($_FILES['slika']) && $_FILES['slika']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $uploaded_file = $upload_dir . basename($_FILES['slika']['name']);
            move_uploaded_file($_FILES['slika']['tmp_name'], $uploaded_file);
            $slika_path = $uploaded_file;
        }

        // Upit za dodavanje blog posta u bazu podataka
        $sql_insert = "INSERT INTO blog_postovi (naslov, sadrzaj, slika, autor_id) VALUES ('$naslov', '$sadrzaj', '$slika_path', '$autor_id')";
        if ($conn->query($sql_insert) === TRUE) {
            echo '<div class="success-message">Blog post je uspešno dodat.</div>';
        } else {
            echo '<div class="error-message">Greška pri dodavanju blog posta: ' . $conn->error . '</div>';
        }
    }
}

// Postavljanje paginacije
$stavke_po_stranici = 3;
$stranica = isset($_GET['stranica']) ? $_GET['stranica'] : 1;
$limit = ($stranica - 1) * $stavke_po_stranici;

// Dohvat ukupnog broja blog postova
$autor_id = $_SESSION['user_id'];
$sql_count = "SELECT COUNT(id) AS ukupno FROM blog_postovi WHERE autor_id = '$autor_id'";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$ukupno_stavki = $row_count['ukupno'];

// Dohvat blog postova za trenutno prijavljenog korisnika sa paginacijom
$sql_select = "SELECT id, naslov, sadrzaj, slika, datum_objave, autor_id, autor_username FROM blog_postovi WHERE autor_id = '$autor_id' LIMIT $limit, $stavke_po_stranici";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dobrodošli</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">

    <h1>Dobrodošli, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Pogledaj ceo <a href="master.php">Wall</a></h2>
    <p>Ovo je vaš blog.</p>

    <!-- Forma za dodavanje, izmenu i brisanje blog posta -->
    <form action="welcome.php" method="post" enctype="multipart/form-data">
        <label for="naslov">Naslov:</label>
        <input type="text" name="naslov" required><br>

        <label for="sadrzaj">Sadržaj:</label>
        <textarea name="sadrzaj" rows="4" required></textarea><br>

        <!-- Dodano polje za upload slike -->
        <label for="slika">Slika:</label>
        <input type="file" name="slika" accept="image/*"><br>

        

        <input type="submit" value="Dodaj blog post">
    </form>

    <!-- Prikaz svih postojećih blog postova -->
    <h2>Vaši blog postovi:</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h2>{$row['naslov']}</h2>";
            echo "<p>{$row['sadrzaj']}</p>";

            // Prikaz postojeće slike ako postoji
            if (!empty($row['slika'])) {
                echo "<img src='{$row['slika']}' alt='Slika' width='200'>";
            }

            echo "<p class='post-date'>Datum objave: {$row['datum_objave']}</p>";
            echo "<p class='post-author'>Autor: {$row['autor_username']}</p>";

            // Dodano: Obrazac za brisanje blog posta
            echo "<form action='welcome.php' method='post'>";
            echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
            echo "<input type='submit' name='delete_post' class='delete-post' value='Obriši post'>";
            echo "</form><br />";

            // Dodano: Obrazac za izmenu blog posta
			echo "<div class='izmena'>";
			echo "<h2>Izmeni post:</h2>";
            echo "<form action='welcome.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
            echo "<label for='naslov'>Naslov:</label>";
            echo "<input type='text' name='naslov' value='{$row['naslov']}' required><br>";

            echo "<label for='sadrzaj'>Sadržaj:</label>";
            echo "<textarea name='sadrzaj' rows='4' required>{$row['sadrzaj']}</textarea><br>";

            // Dodano polje za upload nove slike
            echo "<label for='nova_slika'>Nova slika:</label>";
            echo "<input type='file' name='nova_slika' accept='image/*'><br>";

            echo "<input type='submit' name='update_post' value='Izmeni post'>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }

        // Paginacija
        $ukupno_stranica = ceil($ukupno_stavki / $stavke_po_stranici);
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $ukupno_stranica; $i++) {
            echo "<a href='welcome.php?stranica=$i' ";
            if ($i == $stranica) {
                echo "class='active'";
            }
            echo ">$i</a>";
        }
        echo "</div>";
    } else {
        echo "<p>Nemate nijedan blog post.</p>";
    }
    ?>

    <p><a href="logout.php">Odjava</a></p>

</div>

</body>
</html>
