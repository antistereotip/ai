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
            echo "Naslov: " . $item->title . "<br>";
            echo "Link: " . $item->link . "<br>";
            echo "Opis: " . $item->description . "<br>";
            echo "Datum: " . $item->pubDate . "<br>";
            echo "<hr>"; // Razdelnik između vesti
        }

        // Prikaz paginacije
        for ($str = 1; $str <= $ukupno_strana; $str++) {
            echo '<a href="?strana=' . $str . '">' . $str . '</a> ';
        }
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
