<?php

/**
 * Class ArtistController
 */
class ArtistController extends Controller
{
    /** @var Artist Instance of Artist Class */
    private $artist;

    /**
     * ArtistController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->artist = new Artist();
    }

    public function showArtist()
    {
        $allArtists = Artist::convertArtistArrayForTwig($this->artist->getAllArtists());
        $pageTwig = 'artist.html.twig';
        self::$_twig->addGlobal("arrayArtists", $allArtists);
        echo $this->showPage($pageTwig);
    }




}