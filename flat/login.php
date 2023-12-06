<?php
session_start();

// Provera da li je korisnik već prijavljen
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Učitaj podatke o korisnicima
    $users = file_get_contents('users.txt');
    $users = $users ? json_decode($users, true) : [];

    // Provera korisničkih podataka
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Pogrešno korisničko ime ili lozinka.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php
if (isset($error)) {
    echo "<p>$error</p>";
}
?>

<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
