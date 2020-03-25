<?php

/**
 * Class GenreController
 */
class MovieController extends Controller {

    /** @var Movie Instance of Movie Class */
     private $movie;
    
    public function __construct()
    {
        parent::__construct();
        $this->movie = new Movie();
    }

    public function showMovie()
    {
        $allMovies = Movie::convertMovieArrayForTwig($this->movie->getAllMovies());
        $pageTwig = 'movie.html.twig';
        self::$_twig->addGlobal("arrayMovies", $allMovies);
        echo $this->showPage($pageTwig);
    }




}