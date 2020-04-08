<?php

/**
 * Class GenreController
 */
class HomeController extends Controller {

    /** @var Home Instance of Home Class */
     private $home;
    
    public function __construct()
    {
        parent::__construct();
        $this->home = new Home();
    }

    public function showMovie()
    {
        $allMovies = Home::convertMovieArrayForTwig($this->homegit ->getAllMovies());
        $pageTwig = 'home.html.twig';
        self::$_twig->addGlobal("arrayMovies", $allMovies);
        echo $this->showPage($pageTwig);
    }




}