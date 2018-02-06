<?php
/**************************************
Generic functions
**************************************/
function initAPI(){
	$accessToken = $_SESSION['token'];
    $api = new SpotifyWebAPI\SpotifyWebAPI();
	$api->setAccessToken($accessToken);
	
	return $api;
}

function errorManagement($e){
	if ($e->getCode() == 429) { // 429 = Rate limit
		$result = array(
			"errorCode" => 429,
			"errorMsg" => "<p class='errorMessage'>Rate Limit atteint. Veuillez attendre quelques secondes avant de ré-essayer</p>"
		);
	} elseif ($e->getCode() == 401) { // 401 = Unauthorized
		$result = array(
			"errorCode" => 401,
			"errorMsg" => '<p class="errorMessage">Problème avec la connexion Spotify. Veuillez vous reconnecter</p>
			<form class="text-center" action="index.php">
				<button type="submit" class="btn btn-spotify" name="page" value="authentication">Connexion Spotify</button>
			</form>'
		);
	} else {
		$result = array(
			"errorCode" => $e->getCode(),
			"errorMsg" => '<p class="errorMessage">Spotify API Error: '. $e->getCode().'</p>'
		);
	}

	return $result;
}

/**************************************
Data functions
**************************************/

function myInfo(){
	$api = initAPI();
	try {
		$me = $api->me();
		$_SESSION['userId'] = $me->id;
	} catch (Exception $e) {
		$me = errorManagement($e);	
	}

	return $me;
}

function searchArtist($query){
	$api = initAPI();
	try {
		$result = $api->search($query, 'artist');
	} catch (Exception $e) {
		$result = errorManagement($e);	
	}

	return $result;
}

function getArtistDetails($artistId){
	$api = initAPI();
	try {
		$artistInfo = $api->getArtist($artistId);
		$artistAlbums = $api->getArtistAlbums($artistId, ["album_type" => ["album"]]);
		$artistSingles = $api->getArtistAlbums($artistId, ["album_type" => ["single"]]);
		$artistTopTracks = $api->getArtistTopTracks($artistId, [
			'country' => 'fr',
		]);
		$artistSimilar = $api->getArtistRelatedArtists($artistId);
		$result = array(
			'info' => $artistInfo,
			'albums' => $artistAlbums,
			'singles' => $artistSingles,
			'topTracks' => $artistTopTracks,
			'similar' => $artistSimilar
		);
	} catch (Exception $e) {
		$result = errorManagement($e);	
	}

	return $result;
}

function getAlbumDetails($albumId){
	$api = initAPI();
	try {
		$result = $api->getAlbum($albumId);
	} catch (Exception $e) {
		$result = errorManagement($e);	
	}

	return $result;
}

function getMyTopArtists(){
	$api = initAPI();
	try {
		$result = $api->getMyTop('artists', 'limit=20');
	} catch (Exception $e) {
		$result = errorManagement($e);	
	}

	return $result;
}

function getMyAlbums($offset=0){
	
	$api = initAPI();
	try {
		$result = $api->getMySavedAlbums('offset='.$offset);
	} catch (Exception $e) {
		$result = errorManagement($e);	
	}

	return $result;
}



?>
