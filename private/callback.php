<?php
require '../vendor/autoload.php';
session_start();

$session = new SpotifyWebAPI\Session(
    'client_id',
    'client_secret',
    'redirect_url'
);

// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);

$accessToken = $session->getAccessToken();
$refreshToken = $session->getRefreshToken();

$_SESSION['token'] = $accessToken;
$_SESSION['refreshToken'] = $refreshToken;

// Send the user along and fetch some data!
header('Location: ../index.php?page=homeConnected');
die();

?>