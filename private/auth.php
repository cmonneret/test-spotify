<?php
require '../vendor/autoload.php';


$session = new SpotifyWebAPI\Session(
    'client_id',
    'client_secret',
    'redirect_url'
);

$options = [
    'scope' => [
        'playlist-read-private',
        'user-read-private',
        'user-follow-read',
        'user-library-read',
        'user-top-read'
    ],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();

?>