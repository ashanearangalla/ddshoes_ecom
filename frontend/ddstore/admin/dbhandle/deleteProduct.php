<?php
if (!isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$productId = intval($_GET['id']);
$productApiUrl = "https://localhost:7262/api/Product/$productId";

$response = makeCurlRequest($productApiUrl, 'DELETE');

if ($response === false) {
    echo json_encode(['success' => false]);
} else {
    echo json_encode(['success' => true]);
}

function makeCurlRequest($url, $method = 'DELETE') {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    if ($method == 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode != 200 && $httpCode != 204) {
        return false;
    }

    return $response;
}
?>
