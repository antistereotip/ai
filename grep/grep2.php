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

// Korišćenje DOMXPath za navigaciju kroz dokument
$xpath = new DOMXPath($dom);

// Pronalaženje naslova (h1, h2, h3, h4, h5, h6 tagova)
$headings = array();
for ($i = 1; $i <= 6; $i++) {
    $headings[$i] = $dom->getElementsByTagName('h' . $i);
}

// Pronalaženje paragrafa (p tagova)
$paragraphs = $dom->getElementsByTagName('p');

// Pronalaženje linkova (a href)
$links = $dom->getElementsByTagName('a');

// Pronalaženje ikona društvenih mreža
$socialIcons = array();
$socialIconClasses = array('facebook', 'twitter', 'instagram'); // Dodajte druge klase po potrebi

foreach ($socialIconClasses as $class) {
    $query = "//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]";
    $socialIcons[$class] = $xpath->query($query);
}

// Ispis rezultata
echo "Pronađeni rezultati:<br>";

// Prikazivanje naslova
for ($i = 1; $i <= 6; $i++) {
    if ($headings[$i]->length > 0) {
        echo "<h$i>Naslovi h$i:</h$i>";
        foreach ($headings[$i] as $heading) {
            echo $heading->nodeValue . "<br>";
        }
    } else {
        echo "Nema rezultata za h$i naslove.<br>";
    }
}

// Prikazivanje paragrafa
if ($paragraphs->length > 0) {
    echo "<p>Paragrafi:</p>";
    foreach ($paragraphs as $paragraph) {
        echo $paragraph->nodeValue . "<br>";
    }
} else {
    echo "Nema rezultata za paragrafe.<br>";
}

// Prikazivanje linkova
if ($links->length > 0) {
    echo "<p>Linkovi:</p>";
    foreach ($links as $link) {
        echo $link->getAttribute('href') . "<br>";
    }
} else {
    echo "Nema rezultata za linkove.<br>";
}

// Prikazivanje ikona društvenih mreža
echo "<p>Ikone društvenih mreža:</p>";
foreach ($socialIcons as $class => $icons) {
    if ($icons->length > 0) {
        echo "Pronađena ikona društvene mreže $class.<br>";
    } else {
        echo "Nema rezultata za ikonu društvene mreže $class.<br>";
    }
}

?>
