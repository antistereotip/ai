<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
// Povezivanje s bazom podataka
$conn = new mysqli('localhost', 'root', '', 'cms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Unos PDF-a
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $file_name = $_FILES['pdf_file']['name'];
    $file_tmp = $_FILES['pdf_file']['tmp_name'];
    $file_path = 'uploads/' . $file_name;

    move_uploaded_file($file_tmp, $file_path);

    $sql = "INSERT INTO pdf_documents (file_name, file_path) VALUES ('$file_name', '$file_path')";
    $conn->query($sql);
}

// Brisanje PDF-a
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = $_GET['delete'];

    // Provjeri postoji li dokument prije brisanja
    $result = $conn->query("SELECT * FROM pdf_documents WHERE id = $deleteId");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        unlink($row['file_path']); // Briše stvarni fizički PDF
        $conn->query("DELETE FROM pdf_documents WHERE id = $deleteId");
    }
}

// Paginacija
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Prikaz PDF-ova s paginacijom i pretragom
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = $search_query ? " AND file_name LIKE '%$search_query%'" : '';

$query = "SELECT * FROM pdf_documents WHERE 1 $search_condition ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

if (!$result) {
    die("Error in query: $query. " . $conn->error);
}

// Ukupan broj stranica za paginaciju i pretragu
$total_pages_query = $conn->query("SELECT COUNT(*) FROM pdf_documents WHERE 1 $search_condition");
if (!$total_pages_query) {
    die("Error in query: " . $conn->error);
}
$total_pages = ceil($total_pages_query->fetch_row()[0] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            color: #007BFF;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="file"] {
            margin-right: 10px;
            padding: 8px;
        }

        button {
            padding: 8px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        a {
			background: #007BFF;
			color: #ffffff;
			text-decoration: none;
			border: 1px solid #007BFF;
			padding: 0.3%;
			border-radius: 5px 5px;
			padding-left: 0.6%;
			padding-right: 0.6%;
		}

        a:hover {
			text-decoration: none;
			background: #ff0000;
			color: #ffffff;
			border: 1px solid #ff0000;
		}
		/* Dodatak u CSS-u za aktivni link */
		a.active {
			background-color: #ff0000;
			border: 1px solid #ff0000;
			color: #fff;
			padding: 6px 8px;
			border-radius: 5px;
			text-decoration: none;
		}
		a.active:hover {
			background-color: #ff0000;
		}
    </style>
</head>
<body>
    <h1>PDF</h1>
	<a href="logout.php">Odjavi se</a><br /><br />

    <!-- Forma za unos PDF-a -->
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept=".pdf" required>
        <button type="submit">Dodaj PDF</button>
    </form>

    <!-- Forma za pretragu PDF-ova -->
    <form action="index.php" method="get">
        <input type="text" name="search" placeholder="Pretraži PDF fajlove" value="<?php echo $search_query; ?>" style="padding: 0.5%; border-radius: 3px; border: 1px solid #333;">
        <button type="submit">Pretraži</button>
    </form>

    <!-- Prikaz lista PDF-ova -->
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['file_name']} - <a href='{$row['file_path']}' target='_blank'>Pregledaj</a> - <a href='index.php?delete={$row['id']}' onclick='return confirm(\"Jeste li sigurni da želite izbrisati ovaj dokument?\")'>Izbriši</a> - <a href='comments.php?pdf_id={$row['id']}'>Komentari</a></li>";
        }
        ?>
    </ul>

    <!-- Paginacija -->
    <?php
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    echo "<div>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $active_class = ($i == $current_page) ? 'active' : ''; // Dodaje klasu 'active' za trenutnu stranicu
        echo "<a class='page $active_class' href='index.php?page=$i&search=$search_query'>$i</a> ";
    }
    echo "</div>";
    ?>

</body>
</html>
