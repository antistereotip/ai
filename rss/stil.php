<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feed with Pagination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .feed-item {
            margin-bottom: 20px;
        }

        .feed-item h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .feed-item p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .feed-item small {
            font-size: 12px;
            color: #777;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        .pagination a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php

function citaj_rss_feed($url, $strana = 1, $vesti_po_strani = 7) {
    $feed = simplexml_load_file($url);

    if ($feed) {
        $ukupno_vesti = count($feed->channel->item);
        $ukupno_strana = ceil($ukupno_vesti / $vesti_po_strani);

        $pocetak_indeks = ($strana - 1) * $vesti_po_strani;
        $kraj_indeks = $pocetak_indeks + $vesti_po_strani - 1;

        for ($i = $pocetak_indeks; $i <= $kraj_indeks && $i < $ukupno_vesti; $i++) {
            $item = $feed->channel->item[$i];
            echo '<div class="feed-item">';
            echo '<h2>' . $item->title . '</h2>';
            echo '<p>' . $item->description . '</p>';
            echo '<small>Datum: ' . $item->pubDate . '</small>';
            echo '</div>';
        }

        // Prikaz paginacije
        echo '<div class="pagination">';
        for ($str = 1; $str <= $ukupno_strana; $str++) {
            echo '<a href="?strana=' . $str . '">' . $str . '</a> ';
        }
        echo '</div>';
    } else {
        echo "Nema vesti u feedu.";
    }
}

// Uzimanje trenutne strane iz URL-a, ako nije postavljena postaviće se na 1
$strana = isset($_GET['strana']) ? (int)$_GET['strana'] : 1;

// Primer korišćenja
$rss_url = "https://feeds.bbci.co.uk/news/rss.xml";
citaj_rss_feed($rss_url, $strana);

?>

</body>
</html>
