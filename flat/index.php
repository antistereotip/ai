<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
</head>
<body>

<h1>My Simple Blog</h1>

<!-- Display existing posts -->
<?php
$posts = file_get_contents('posts.txt');

if ($posts) {
    $posts = json_decode($posts, true);

    // Proveri da li je $posts niz pre nego što pokušaš foreach
    if (is_array($posts)) {
        foreach ($posts as $post) {
            echo "<h2>{$post['title']}</h2>";
            echo "<p>{$post['content']}</p>";
            echo "<p>Posted on: {$post['date']}</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No posts available.</p>";
    }
} else {
    echo "<p>No posts available.</p>";
}
?>

<!-- Form to add a new post -->
<h2>Add a New Post</h2>
<form action="add_post.php" method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br>
    <label for="content">Content:</label>
    <textarea name="content" required></textarea><br>
    <input type="submit" value="Add Post">
</form>

</body>
</html>
