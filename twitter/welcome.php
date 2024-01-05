<?php
session_start();

// Provera da li je korisnik prijavljen
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Povezivanje s bazom podataka
require_once 'db_connection.php';

// Obrada podataka sa forme za dodavanje novog posta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['naslov'];
    $post = $_POST['post'];
    $datum = $_POST['datum'];
    $autor = $_SESSION['username'];

    // Postavljanje putanje za čuvanje slika u folder "uploads"
    $uploadsDir = 'uploads/';

    // Postavljanje putanje za čuvanje slike sa jedinstvenim imenom
    $slikaPath = $uploadsDir . basename($_FILES['slika']['name']);

    // Dobijanje ekstenzije slike
    $imageFileType = strtolower(pathinfo($slikaPath, PATHINFO_EXTENSION));

    // Dozvoljeni formati slika
    $allowedFormats = array('png', 'jpg', 'jpeg', 'gif');

    // Provera da li je izabrani format dozvoljen
    if (in_array($imageFileType, $allowedFormats)) {
        // Pomeranje upload-ovane slike u odredišni folder
        if (move_uploaded_file($_FILES['slika']['tmp_name'], $slikaPath)) {
            // SQL upit za unos podataka u tabelu "postovi"
            $sql_insert = "INSERT INTO postovi (naslov, post, slika_path, datum, autor) VALUES ('$naslov', '$post', '$slikaPath', '$datum', '$autor')";
            $result_insert = $conn->query($sql_insert);

            if ($result_insert) {
                // Redirekcija na welcome.php kako bi se izbeglo ponovno slanje podataka prilikom osvežavanja
                header("Location: welcome.php");
                exit();
            } else {
                echo "Greška prilikom unosa podataka u bazu podataka.";
            }
        } else {
            echo "Došlo je do greške prilikom upload-a slike.";
        }
    } else {
        echo "Nedozvoljen format slike. Molimo izaberite png, jpg, jpeg ili gif.";
    }
}

// Postavke paginacije
$postovaPoStranici = 3;
$sql_select_all = "SELECT COUNT(*) AS broj_postova FROM postovi WHERE autor = '{$_SESSION['username']}'";
$result_select_all = $conn->query($sql_select_all);
$ukupnoPostova = $result_select_all->fetch_assoc()['broj_postova'];
$ukupnoStranica = ceil($ukupnoPostova / $postovaPoStranici);

if (isset($_GET['stranica'])) {
    $stranica = $_GET['stranica'];
} else {
    $stranica = 1;
}

$pocetniRedniBroj = ($stranica - 1) * $postovaPoStranici;

// Dodatak za pretragu
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $sql_search = "SELECT * FROM postovi WHERE autor = '{$_SESSION['username']}' AND (naslov LIKE '%$searchTerm%' OR post LIKE '%$searchTerm%') ORDER BY id DESC LIMIT $pocetniRedniBroj, $postovaPoStranici";
    $result_select = $conn->query($sql_search);
} else {
    $sql_select = "SELECT * FROM postovi WHERE autor = '{$_SESSION['username']}' ORDER BY id DESC LIMIT $pocetniRedniBroj, $postovaPoStranici";
    $result_select = $conn->query($sql_select);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form textarea,
        form input[type="file"],
        form input[type="date"],
        form input[type="submit"] {
            margin-bottom: 10px;
        }

        .post-container {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .post-container img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        .post-container p {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1><a href="logout.php">Logout</a>
    
    <h2>Napišite novi post:</h2>
    <form action="welcome.php" method="POST" enctype="multipart/form-data">
        <label for="naslov">Naslov:</label>
        <input type="text" name="naslov" required><br>

        <label for="post">Post:</label>
        <textarea name="post" rows="4" required></textarea><br>

        <label for="slika">Izaberite sliku (png, jpg, jpeg, gif):</label>
        <input type="file" name="slika" accept="image/png, image/jpeg, image/jpg, image/gif" required><br>

        <label for="datum">Datum:</label>
        <input type="date" name="datum" required><br>

        <input type="submit" value="Objavi">
    </form>

    <h2>Pretraga postova:</h2>
    <form action="welcome.php" method="GET">
        <label for="search">Pretraga:</label>
        <input type="text" name="search" value="<?php echo $searchTerm; ?>">
        <input type="submit" value="Traži">
    </form>

    <h2>Vaši postovi:</h2>
    <?php
    // Prikazivanje postojećih postova korisnika
    if ($result_select->num_rows > 0) {
        while ($row = $result_select->fetch_assoc()) {
            echo "<div class='post-container'>";
            echo "<p>Naslov: " . $row['naslov'] . "</p>";
            echo "<p>Post: " . $row['post'] . "</p>";
            echo "<p>Datum: " . $row['datum'] . "</p>";
            echo "<img src='" . $row['slika_path'] . "' alt='Slika' width='300'>";
            echo "<p>Autor: " . $row['autor'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "Nemate još nijedan post.";
    }
    ?>

    <div class="pagination">
        <?php
        // Dodavanje navigacije za paginaciju
        for ($i = 1; $i <= $ukupnoStranica; $i++) {
            $activeClass = ($stranica == $i) ? 'active' : '';
            echo "<a href='welcome.php?stranica=$i&search=$searchTerm' class='$activeClass'>$i</a> ";
        }
        ?>
    </div>
</body>
</html>
