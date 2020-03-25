<?php
require_once 'vendor/autoload.php';
session_start();

/**
 * <b>TRUE</b> for debug <b>FALSE</b> for none
 * @var bool DEBUG
 */
define('DEBUG', true);

if (isset($_GET['uri']) && ($_GET['uri'] !== "")) {
    $mainRouter = new Router($_GET['uri']);
} else {
    $mainRouter = new Router("/");
}

header('Cache-Control: no-cache');


//// GET
// Public
$mainRouter->addRouteGET('/admin', 'AdminHome.showHomeAdmin');
$mainRouter->addRouteGET('/genre', 'Genre.showGenre');
$mainRouter->addRouteGET('/artist', 'Artist.showArtist');
$mainRouter->addRouteGET('/director', 'Director.showDirector');
$mainRouter->addRouteGET('/movie', 'Movie.showMovie');
$mainRouter->addRouteGET('/', 'Home.showHome');
$mainRouter->error404GET(":file");

// AdminGenre
$mainRouter->addRouteGET('/admin/genre/get/:id', 'AdminGenre.getGenreDataJSON');
$mainRouter->addRouteGET('/admin/genre/add', 'AdminGenre.showAddGenre');
$mainRouter->addRouteGET('/admin/genre/edit', 'AdminGenre.showEditGenre');
$mainRouter->addRouteGET('/admin/genre/delete', 'AdminGenre.showDelGenre');
// AdminArtist
$mainRouter->addRouteGET('/admin/artist/get/:id', 'AdminArtist.getArtistDataJSON');
$mainRouter->addRouteGET('/admin/artist/add', 'AdminArtist.showAddArtist');
$mainRouter->addRouteGET('/admin/artist/edit', 'AdminArtist.showEditArtist');
$mainRouter->addRouteGET('/admin/artist/delete', 'AdminArtist.showDelArtist');
// AdminMovie
$mainRouter->addRouteGET('/admin/movie/get/:id', 'AdminMovie.getMovieDataJSON');
$mainRouter->addRouteGET('/admin/movie/add', 'AdminMovie.showAddMovie');
$mainRouter->addRouteGET('/admin/movie/edit', 'AdminMovie.showEditMovie');
$mainRouter->addRouteGET('/admin/movie/delete', 'AdminMovie.showDelMovie');


//// POST
$mainRouter->addRoutePOST('/admin/genre/add', 'AdminGenre.insertNewGenre');
$mainRouter->addRoutePOST('/admin/genre/edit', 'AdminGenre.editGenre');
$mainRouter->addRoutePOST('/admin/genre/delete', 'AdminGenre.deleteGenre');

$mainRouter->addRoutePOST('/admin/artist/add', 'AdminArtist.insertNewArtist');
$mainRouter->addRoutePOST('/admin/artist/edit', 'AdminArtist.editArtist');
$mainRouter->addRoutePOST('/admin/artist/delete', 'AdminArtist.deleteArtist');

$mainRouter->addRoutePOST('/admin/movie/add', 'AdminMovie.insertNewMovie');
$mainRouter->addRoutePOST('/admin/movie/edit', 'AdminMovie.editMovie');
$mainRouter->addRoutePOST('/admin/movie/delete', 'AdminMovie.deleteMovie');
//Admin

$mainRouter->addRoutePOST('/admin/login', 'AdminHome.postLogIn');

try {
    $mainRouter->startRouter();
} catch (RouterException $e) {
    if (DEBUG) {
        die('Error when starting the router: ' . $e->getMessage());
    }
    die();
}


