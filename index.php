<?php
session_start();
require 'vendor/autoload.php';
/*functions files inclusion*/
require_once('include/functions.php');
require_once('include/displayFunctions.php');

//init page value
$page='home';   // default value
if (isset($_REQUEST['page'])) $page = $_REQUEST['page'];

//header display
displayHeader($page);

// ********* Routes

switch ($page) {
	//home display
	case 'home':
		displayConnexionRequest();
        break;
    
    case 'authentication':
        header('Location: private/auth.php'); //go to authentication page, then callback
        die;
        break;

    case 'homeConnected':
        $me = myInfo();
        displayHomeConnected($me);
        break;
    
    case 'search':
        if (isset($_REQUEST['query']) AND !empty($_REQUEST['query'])) {
            $result = searchArtist($_REQUEST['query']);
            displaySearch($result, $_REQUEST['query']);
        } else {
            displaySearch();
        }
        break;

    case 'myArtists':
        $result = getMyTopArtists();
        displayTopArtists($result);
        break;

    case 'myAlbums':
        if (isset($_REQUEST['offset'])) {
            $result = getMyalbums($_REQUEST['offset']);
            displayMyAlbums($result, $_REQUEST['offset']);
        } else {
            $result = getMyalbums();
            displayMyAlbums($result);
        }
        break;

    case 'artistPage':
        $result = getArtistDetails($_REQUEST['artistId']);
        displayArtistPage($result);
        break;

    case 'albumPage':
        $result = getAlbumDetails($_REQUEST['albumId']);
        displayAlbumPage($result);
        break;

    case 'logout':
        session_destroy();
        session_unset();
        header('location: index.php?page=home');
        die;
        break;

}



displayFooter(); // footer display

?>