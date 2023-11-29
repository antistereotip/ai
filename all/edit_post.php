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

// Provjera ako je obrazac za izmenu blog posta poslan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_post'])) {
    $post_id = $_POST['post_id'];

    // Dohvatanje informacija o postojećem blog postu
    $sql_select_post = "SELECT id, naslov, sadrzaj, slika FROM blog_postovi WHERE id = '$post_id' AND autor_id = " . $_SESSION['user_id'];
    $result_select_post = $conn->query($sql_select_post);

    if ($result_select_post->num_rows > 0) {
        $row_post = $result_select_post->fetch_assoc();
    } else {
        // Ako post ne postoji ili ne pripada trenutnom korisniku
        header("Location: welcome.php");
        exit();
    }
} else {
    // Ako nije poslan obrazac za izmenu
    header("Location: welcome.php");
    exit();
}

// Provjera ako je obrazac za izmenu podataka poslan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    $naslov = $_POST['naslov'];
    $sadrzaj = $_POST['sadrzaj'];
    $nova_slika_path = null;

    // Obrada upload-a nove slike
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
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Izmeni blog post</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">

    <h1>Izmeni blog post</h1>

    <!-- Forma za izmenu blog posta -->
    <form action="edit_post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?php echo $row_post['id']; ?>">

        <label for="naslov">Naslov:</label>
        <input type="text" name="naslov" value="<?php echo $row_post['naslov']; ?>" required><br>

        <label for="sadrzaj">Sadržaj:</label>
        <textarea name="sadrzaj" rows="4" required><?php echo $row_post['sadrzaj']; ?></textarea><br>

        <!-- Dodano polje za upload nove slike -->
        <label for="nova_slika">Nova slika:</label>
        <input type="file" name="nova_slika" accept="image/*"><br>

        <input type="submit" name="update_post" value="Izmeni post">
    </form>

    <p><a href="welcome.php">Nazad na blog</a></p>

</div>

</body>
</html>
