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

$titre = preg_replace('/\([^)]*\)/', '', $title);
$titre = preg_replace('/\s?-\s?.*/', '', $titre);
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

$artistname = $artiste->getNomDeScene();
if ($artistname == "Queen Bee") {
    $artistname = "Ziyoou-vachi";
}
if ($artistname == "TK from Ling tosite sigure") {
    $artistname = "TK";
}
$result = fetchAnimeSongs($titre, $artistname);

echo "<img src=".$image.">";
echo "<h2>Artist : {$artiste->getNomDeScene()}</h2>";
echo "<h2>Real name : {$artiste->getNom()} {$artiste->getPrenom()}</h2>";
echo "<h2>Titre : ".$title."</h2>";
echo "<a href='{$artiste->getLienNautijon()}'>Nautijon</a>";

if (isset($result['songs']) && is_array($result['songs'])) {
        foreach ($result['songs'] as $song) {
            if ($song['version'] == null) {
            echo "<h2>Anime : " . $song['anime'][0]['name'] . "</h2><br>";
            break;
            }
        }
    }
else {
    echo "<h2>Aucune chanson trouvée</h2>";
}
echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";
echo "<br>
<br>
    <form method=\"post\" action=\"\">
        <input type=\"submit\" value=\"Next\" name='next'>
        <input type=\"submit\" value=\"Stop\" name='stop'>
        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='next'>
<br><br>
<br><br>";