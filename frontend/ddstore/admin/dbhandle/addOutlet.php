<?php
// Define the API URLs
$userApiUrl = 'https://localhost:7262/api/User';
$outletApiUrl = 'https://localhost:7262/api/Outlet';

// Get POST data
$outletName = $_POST['outletName'];
$managerName = $_POST['managerName'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = 'OutletManager';
$location = $_POST['location'];

// Function to make cURL requests
function makeCurlRequest($url, $data) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode != 200) {
        return false;
    }

    return $response;
}

// Create user
$userData = json_encode([
    "userID" => 0,
    "username" => $username,
    "password" => $password,
    "role" => $role
]);

$userResponse = makeCurlRequest($userApiUrl, $userData);

if ($userResponse === false) {
    die('Error occurred while creating user.');
}

$userResponseData = json_decode($userResponse, true);
$userID = $userResponseData['id'] ?? -1; // Adjust based on the actual API response structure

if ($userID <= 0) {
    die('Failed to get user ID.');
}

// Create outlet
$outletData = json_encode([
    "outletID" => 0,
    "outletName" => $outletName,
    "location" => $location,
    "userID" => $userID
]);

$outletResponse = makeCurlRequest($outletApiUrl, $outletData);

if ($outletResponse === false) {
    die('Error occurred while creating outlet.');
}

header("Location: ../addOutlets.php");
            exit();
?>
