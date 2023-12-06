<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');

    // Učitaj postojeće postove
    $posts = file_get_contents('posts.txt');
    $posts = $posts ? json_decode($posts, true) : [];

    // Proveri da li je $posts niz pre dodavanja novog posta
    if (!is_array($posts)) {
        $posts = []; // Ako nije niz, inicijalizujemo ga kao prazan niz
    }

    // Dodaj novi post
    $newPost = [
        'title' => $title,
        'content' => $content,
        'date' => $date,
    ];

    // Dodaj novi post u niz
    $posts[] = $newPost;

    // Sačuvaj promene nazad u file.txt
    file_put_contents('posts.txt', json_encode($posts));
}

// Preusmeri nazad na glavnu stranicu
header('Location: index.php');
?>
