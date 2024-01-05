<?php

// Unesite URL koji želite pretraživati
$url = "https://opremazaigraonice.rs";


// Preuzmi sadržaj sa URL-a
$html = file_get_contents($url);

// Provera da li je sadržaj uspešno preuzet
if ($html === FALSE) {
    die('Nije moguće preuzeti sadržaj.');
}

// Korišćenje DOMDocument za analizu HTML-a
$dom = new DOMDocument;
@$dom->loadHTML($html); // Ignorišite greške koje nisu bitne

// Pronalaženje naslova (h1 i h2 tagova)
$headings = $dom->getElementsByTagName('h1');
$headings2 = $dom->getElementsByTagName('h2');

// Ispis rezultata
echo "Pronađeni rezultati:<br>";

// Prikazivanje h1 naslova
if ($headings->length > 0) {
    echo "<h1>Naslovi h1:</h1>";
    foreach ($headings as $heading) {
        echo $heading->nodeValue . "<br>";
    }
} else {
    echo "Nema rezultata za h1 naslove.<br>";
}

// Prikazivanje h2 naslova
if ($headings2->length > 0) {
    echo "<h2>Naslovi h2:</h2>";
    foreach ($headings2 as $heading) {
        echo $heading->nodeValue . "<br>";
    }
} else {
    echo "Nema rezultata za h2 naslove.<br>";
}

?>
