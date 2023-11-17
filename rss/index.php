<?php

function citaj_rss_feed($url) {
    $feed = simplexml_load_file($url);

    if ($feed) {
        foreach ($feed->channel->item as $item) {
            echo "Naslov: " . $item->title . "<br>";
            echo "Link: " . $item->link . "<br>";
            echo "Opis: " . $item->description . "<br>";
            echo "Datum: " . $item->pubDate . "<br>";
            echo "<hr>"; // Razdelnik između vesti
        }
    } else {
        echo "Nema vesti u feedu.";
    }
}

// Primer korišćenja
$rss_url = "https://feeds.bbci.co.uk/news/rss.xml";
citaj_rss_feed($rss_url);

?>
