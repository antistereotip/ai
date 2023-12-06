<?php
session_start();

if (!isset($_SESSION['korisnik_id'])) {
    // Ako korisnik nije prijavljen, preusmerite ga na prijavu
    header('Location: login_form.html');
    exit();
}

$korisnicko_ime = $_SESSION['korisnicko_ime'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dobrodošli, <?php echo $korisnicko_ime; ?></title>
</head>
<body>
    <h2>Dobrodošli, <?php echo $korisnicko_ime; ?>!</h2>
    <p>Ovo je sigurna stranica kojoj možete pristupiti samo ako ste prijavljeni.</p>
    <p><a href="logout.php">Odjava</a></p>
</body>
</html>
