<?php

/**
 * Class GenreController
 */
class GenreController extends Controller
{

    /** @var Genre Instance of Genre Class */
    private $genre;

    public function __construct()
    {
        parent::__construct();
        $this->genre = new Genre();
    }

    public function showGenre()
    {
        $allGenres = Genre::convertGenreArrayForTwig($this->genre->getAllGenres());

        $pageTwig = 'genre.html.twig';

        self::$_twig->addGlobal("arrayGenres", $allGenres);
        echo $this->showPage($pageTwig);
    }
}