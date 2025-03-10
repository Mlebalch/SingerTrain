<?php
/**
 * @var \App\Modele\DataObject\Artiste $artiste
 * @var  bool $reponse
 * @var  string $title
 * @var  string $image
 */


if ($reponse) {
    echo "<h1>Correct!$title</h1><img src=".$image.">";

} else {
    echo "<h1>Incorrect!$title</h1><img src=".$image.">";


}

echo "<h2>Artist: {$artiste->getNomDeScene()}</h2>";
echo "<h2>Real name: {$artiste->getNom()} {$artiste->getPrenom()}</h2>";
echo "<a href='{$artiste->getLienNautijon()}'>Nautijon</a>";

echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";

echo "<a href='?controleur=utilisateur&action=next'>Next</a>";
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

$musicname = isset($_GET['musicname']) ? trim($_GET['musicname']) : '';
$artist = isset($_GET['artist']) ? trim($_GET['artist']) : '';

if (empty($musicname) || empty($artist)) {
    echo json_encode(["error" => "Missing required parameters: musicname and artist"]);
    exit;
}

$result = fetchAnimeSongs($musicname, $artist);

if (isset($result['songs']) && is_array($result['songs'])) {
    foreach($result['songs'] as $song){
        if(strtolower($song['name'])==strtolower($musicname)){
            echo "<br><br>";
            echo "Anime : " . ($song['anime'][0]['name'] ?? 'Inconnu') . "<br>";
        }
    }
    }
else {
    echo "Aucune chanson trouvée.";
}

