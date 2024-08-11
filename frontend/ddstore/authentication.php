<?php
session_start(); // Start session for storing user information

// Function to check password via API
function checkPassword($url, $username, $password) {
    $data = array('Username' => $username, 'Password' => $password);
    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)
    ));

    // Disable SSL verification for local testing, adjust for production
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array(
        'response' => json_decode($result, true),
        'http_code' => $http_code
    );
}

// Get the posted username and password from the form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check user authentication
$userUrl = 'https://localhost:7262/api/User/checkpassword';
$userResult = checkPassword($userUrl, $username, $password);

if ($userResult['http_code'] == 200) {
    // User authenticated successfully, store user info in session
    $_SESSION['user'] = array(
        'userID' => $userResult['response']['id'],
        'username' => $username,
        'role' => $userResult['response']['role'] // Assuming the role is returned in the response
    );

    // Redirect based on user role
    if ($userResult['response']['role'] == 'OutletManager' || $userResult['response']['role'] == 'Partner') {
        header('Location: ddusers/viewsales.php');
    } elseif ($userResult['response']['role'] == 'Admin') {
        header('Location: admin/viewstock.php');
    } else {
        // Handle other roles if necessary
        header('Location: defaultPage.php'); // Change to an appropriate default page
    }
    exit;
} else {
    // Authentication failed, redirect to login with error message
    $_SESSION['message'] = $userResult['response']['message'] ?? 'Error occurred during authentication';
    header('Location: login.php');
    exit;
}
?>
