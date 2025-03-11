<?php
/**
 * @var \App\Modele\DataObject\Artiste $artiste
 * @var  bool $reponse
 * @var  string $title
 * @var  string $image
 */


if ($reponse) {
    echo "<h1>Correct!</h1>";
} else {
    echo "<h1>Incorrect!</h1>";
}

echo "<img src=".$image.">";
echo "<h2>Artist: {$artiste->getNomDeScene()}</h2>";
echo "<h2>Real name: {$artiste->getNom()} {$artiste->getPrenom()}</h2>";
echo "<h2>Titre: {$title}</h2>";
echo "<a href='{$artiste->getLienNautijon()}'>Nautijon</a>";

echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";
function fetchAnimeSongs($music, $artist) {
    $baseUrl = "https://animesongs.org/api/songs/search";
    $query = http_build_query([
        'q' => "$artist $music",
        'expand' => 'anime,artists',
        'per-page' => 10
    ]);

    $url = "$baseUrl?$query";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return ["error" => "cURL Error: $error"];
    }
    curl_close($ch);
    if ($httpCode !== 200) {
        return ["error" => "HTTP Error: $httpCode"];
    }
    return json_decode($response, true);
}

$result = fetchAnimeSongs($title, $artiste->getNomDeScene());

if (isset($result['songs']) && is_array($result['songs'])) {
            echo "<h2>Anime : " . ($result['songs'][0]['anime'][0]['name'] ?? 'Inconnu') . "</h2><br>";
        }
else {
    echo "<h2>Aucune chanson trouvée</h2>";
}

echo "<br>
<br><a href='?controleur=utilisateur&action=next'>Next</a>
<br>
<br>
<br>
<br>";