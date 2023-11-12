<?php
session_start();

// Povezivanje s bazom podataka
$conn = new mysqli('localhost', 'root', '', 'cms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provera da li je korisnik prijavljen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Provera da li je postavljen document_id u URL-u
if (!isset($_GET['document_id']) || !is_numeric($_GET['document_id'])) {
    header("Location: index.php");
    exit();
}

$document_id = $_GET['document_id'];

// Provera da li postoji dokument sa datim id-em
$result = $conn->query("SELECT * FROM documents WHERE id = $document_id");

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$document_row = $result->fetch_assoc();

// Dodavanje komentara
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_text'])) {
    $comment_text = $_POST['comment_text'];

    $sql = "INSERT INTO comments2 (document_id, comment_text) VALUES ($document_id, '$comment_text')";
    $conn->query($sql);
}

// Dohvatanje komentara za dati dokument
$comments_result = $conn->query("SELECT * FROM comments2 WHERE document_id = $document_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #007BFF;
            text-align: center;
        }

        form {
            margin-top: 20px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        /* Dodaj boju ili stilizaciju po želji za datum komentara */
        li small {
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Komentari za dokument: <?php echo $document_row['file_name']; ?></h1>

    <!-- Forma za dodavanje komentara -->
    <form action="comments.php?document_id=<?php echo $document_id; ?>" method="post">
        <label for="comment_text">Dodaj komentar:</label>
        <textarea name="comment_text" rows="4" cols="50" required></textarea>
        <button type="submit">Dodaj</button>
    </form>

    <!-- Prikaz komentara -->
    <ul>
        <?php
        while ($comment_row = $comments_result->fetch_assoc()) {
            echo "<li>{$comment_row['comment_text']} <br><small>{$comment_row['created_at']}</small></li>";
        }
        ?>
   
