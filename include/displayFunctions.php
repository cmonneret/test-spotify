<?php
/***********************************************
Display specific functions
************************************************/

// affichage du haut de page et déclarations html (<head>)
function displayHeader() {
    $html= '
    <!DOCTYPE html> 
    <head>
        <title>Spotify API Test</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />  
        <meta name="language" content="FR"/>
        <meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=yes" /> 
        <meta name="description" content="Site pour test Spotify API" />
        
        <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css">

		<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700,800,900" rel="stylesheet">

        <link rel ="stylesheet"  href="css/style.css" />
    </head>
    <body>
		<div class="conteneurHeader">
			<header class="container">
				<div class="row">	
					<div class="col-md-6">
						<h1 class="titreSite">Test Spotify API</h1>
					</div>';
					if (isset($_SESSION['userId'])) {
						$html .= '
						<div class="col-md-6">
							<p class="infoConnexion">Connecté en tant que <span class="highlight">'.$_SESSION['userId'].'</span> - <a href="index.php?page=logout"><i class="fa fa-power-off"></i> Déconnexion</a></p>
						</div>';
					}
				$html .= '</div>
				<nav id="menu" class="navbar">
					<div class="container-fluid">
						<ul class="nav navbar-nav">';
							if (isset($_SESSION['token'])) {
								$html .= '<li><a href="index.php?page=search">Recherche</a></li>
								<li><a href="index.php?page=myArtists">Mon Top 20 Artistes</a></li>
								<li><a href="index.php?page=myAlbums">Mes Albums</a></li>';
							}
						$html.='</ul>
					</div>
				</nav>
			</header>
		</div>
		<section id="centrePage" class="container">'; // ouverture bloc centre
	echo $html;
}   

// affichage du bas de page    
function displayFooter() { 
    $html=' 
		</section>
		<footer class="container">
			
		</footer>

		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/script.js"></script>
	</body>
    </html>';
   echo $html;
}

function displayConnexionRequest(){
	$html = '
	<p class="text-center">Pour	utiliser ce site, vous devez d\'abord vous connecter à votre compte Spotify</p>
	<form class="text-center" action="index.php">
		<button type="submit" class="btn btn-spotify" name="page" value="authentication">Connexion Spotify</button>
	</form>';

	echo $html;
}

function displayHomeConnected($me){
	if (is_array($me)) {
		$html = $me['errorMsg'];
	} else {
		$html = '<p class="text-center welcomeMsg">Welcome <span class="highlight">'.$me->id.'</span>, vous pouvez maintenant explorer le catalogue Spotify !</p>';
	}
	

	echo $html;
}

function displaySearch($result = null, $query=null){
	$html = '<h2>Recherche d\'artiste</h2>
	<form action="index.php">
		<div class="form-group container">
			<div class="">
				<label for="">Entrez le nom d\'un artiste</label>';
				if (isset($query)) {
					$html .= '<input type="text" class="form-control" id="" placeholder="Artiste" name="query" value="'.$query.'">';
				} else {
					$html .= '<input type="text" class="form-control" id="" placeholder="Artiste" name="query">';
				}
			$html .= '</div>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-spotify" name="page" value="search">Search</button>
		</div>
	</form>';

	if (isset($result)) {
		$html .= displaySearchResult($result);
	}
	
	echo $html;
}

function displaySearchResult($result){
	if (is_array($result)) {
		$html = $result['errorMsg'];
	} else {
		$html = '<div class="artistResultContainer row">';
	
		foreach ($result->artists->items as $value) {
			$html .= '<div class="artistResultBox">
				<div class="artistResultBoxImg">
					<a href="index.php?page=artistPage&artistId='.$value->id.'">
						<img src="'.$value->images[1]->url.'" />
					</a>
				</div>
				<p class="highlight">
					<a href="index.php?page=artistPage&artistId='.$value->id.'">'.$value->name.'</a>
				</p>
			</div>';
		}
	
		$html .= '</div>';
	}
	
	return $html;
}

function displayArtistPage($result){
	if (is_array($result) AND isset($result['errorCode'])) {
		$html = $result['errorMsg'];
	} else {
		$html = '
		<div class="artistIntro">
			<div class="artistIntroImg">
				<img src="'.$result["info"]->images[1]->url.'" />
			</div>
			<p class="artistIntroName">'.$result["info"]->name.'</p>
		</div>';
		if (!empty($result["albums"]->items)) {
			$html .= '<div>
				<h2>Albums<i class="fa fa-angle-up"></i></h2>
				<div class="albumContainer">';
					foreach ($result["albums"]->items as $value) {
						$html .= '<div class="albumBox">
							<div class="albumBoxImg">
								<a href="index.php?page=albumPage&albumId='.$value->id.'">
									<img src="'.$value->images[0]->url.'" />
								</a>
							</div>
							<p class="highlight">
								<a href="index.php?page=albumPage&albumId='.$value->id.'">'.$value->name.'</a>
							</p>
						</div>';
					}
				$html .= '</div>
			</div>';
		}
		if (!empty($result["singles"]->items)) {
			$html .= '<div>
				<h2>Singles<i class="fa fa-angle-up"></i></h2>
				<div class="albumContainer">';
					foreach ($result["singles"]->items as $value) {
						$html .= '<div class="albumBox">
							<div class="albumBoxImg">
								<a href="index.php?page=albumPage&albumId='.$value->id.'">
									<img src="'.$value->images[0]->url.'" />
								</a>
							</div>
							<p class="highlight">
								<a href="index.php?page=albumPage&albumId='.$value->id.'">'.$value->name.'</a>
							</p>
						</div>';
					}
				$html .= '</div>
			</div>';
		}
		if (!empty($result["topTracks"]->tracks)) {
			$html .= '<div>
				<h2>Top tracks<i class="fa fa-angle-up"></i></h2>
				<div class="trackContainer">';
					foreach ($result["topTracks"]->tracks as $value) {
						$html .= '<iframe src="https://open.spotify.com/embed?uri=spotify:track:'.$value->id.'&view=list"
				frameborder="0" allowtransparency="true" height="80"></iframe>';
					}
				$html .= '</div>
			</div>';
		}
		if (!empty($result["similar"]->artists)) {
			$html .= '<div>
				<h2>Artistes similaires<i class="fa fa-angle-up"></i></h2>
				<div class="albumContainer">';
					foreach ($result["similar"]->artists as $value) {
						$html .= '<div class="albumBox">
							<div class="albumBoxImg">
								<a href="index.php?page=artistPage&artistId='.$value->id.'">
									<img src="'.$value->images[1]->url.'" />
								</a>
							</div>
							<p class="highlight">
								<a href="index.php?page=artistPage&artistId='.$value->id.'">'.$value->name.'</a>
							</p>
						</div>';
					}
				$html .= '</div>
			</div>';
		}
	}

	echo $html;
}

function displayAlbumPage($result){
	if (is_array($result)) {
		$html = $result['errorMsg'];
	} else {
		$html = '<div class="albumPageContainer row">
			<div class="albumPageImg col-sm-4">
				<img src="'.$result->images[1]->url.'" />
			</div>
			<div class="col-sm-8">
				<p class="albumName">'.$result->name.'</p class="albumName">
				<p>';
				for ($i=0; $i < count($result->artists); $i++) {
					if ($i == count($result->artists)-1) {
						$html .= '<a class="highlight artistName" href="index.php?page=artistPage&artistId='.$result->artists[$i]->id.'">'.$result->artists[$i]->name.'</a>';
					} else {
						$html .= '<a class="highlight artistName" href="index.php?page=artistPage&artistId='.$result->artists[$i]->id.'">'.$result->artists[$i]->name.'</a> / ';
					}
					
				}
				$html .= '</p>
				<p>Date de sortie : '.$result->release_date.'</p>
				<p>Label : '.$result->label.'</p>
			</div>
			<div class="col-xs-12">
				<iframe src="https://open.spotify.com/embed?uri='.$result->uri.'"
			frameborder="0" allowtransparency="true" width="100%" height="500"></iframe>
			</div>
		</div>';
	}

	echo $html;
}

function displayTopArtists($result){
	if (is_array($result)) {
		$html = $result['errorMsg'];
	} else {
		$html = '<h2>Top 20 Artistes</h2>
		<div class="artistResultContainer row">';
	
			foreach ($result->items as $value) {
				$html .= '<div class="artistResultBox">
					<div class="artistResultBoxImg">
						<a href="index.php?page=artistPage&artistId='.$value->id.'">
							<img src="'.$value->images[1]->url.'" />
						</a>
					</div>
					<p class="highlight">
						<a href="index.php?page=artistPage&artistId='.$value->id.'">'.$value->name.'</a>
					</p>
				</div>';
			}
	
		$html .= '</div>';
	}

	echo $html;
}

function displayMyAlbums($result, $offset=0){
	// offset definition
	if ($offset > 0) {
		$prevOffset = $offset-20;
	}

	if ($offset+20 >= $result->total) {
		$nextOffset = $result->total;
	} else {
		$nextOffset = $offset+20;
	}

	//display
	if (is_array($result)) {
		$html = $result['errorMsg'];
	} else {
		$html = '<h2>Mes albums</h2>
		<div class="navigationMyAlbums row">
			<p class="col-xs-12 text-center">';
				//display only if it's not start page
				if ($offset > 0) {
					$html .= '<a href="index.php?page=myAlbums&offset='.$prevOffset.'"><i class="fa fa-angle-double-left"></i></a>';
				}

				$html .= $offset.' - '.$nextOffset.' / '.$result->total;
				
				//display only if it's not last page
				if ($nextOffset != $result->total) {
					$html .= '<a href="index.php?page=myAlbums&offset='.$nextOffset.'"><i class="fa fa-angle-double-right"></i></a>';
				}
			$html .= '</p>
		</div>
		<div class="albumContainer">';
			foreach ($result->items as $value) {
				$html .= '<div class="albumBox">
					<div class="albumBoxImg">
						<a href="index.php?page=albumPage&albumId='.$value->album->id.'">
							<img src="'.$value->album->images[1]->url.'" />
						</a>
					</div>
					<p class="highlight">
						<a href="index.php?page=albumPage&albumId='.$value->album->id.'">'.$value->album->name.'</a>
					</p>
					<p>';
						for ($i=0; $i < count($value->album->artists); $i++) {
							if ($i == count($value->album->artists)-1) {
								$html .= '<a href="index.php?page=artistPage&artistId='.$value->album->artists[$i]->id.'">'.$value->album->artists[$i]->name.'</a>';
							} else {
								$html .= '<a href="index.php?page=artistPage&artistId='.$value->album->artists[$i]->id.'">'.$value->album->artists[$i]->name.'</a> / ';
							}
							
						}
					$html .= '</p>
				</div>';
			}
		$html .= '</div>';
	}

	echo $html;
}

?>