<?php


/**
 * Class AdminArtistController
 */
class AdminArtistController extends AdminController
{
    /** @var $adminArtist AdminArtist */
    private $adminArtist;
    /** @var $arrayArtists array */
    private $arrayArtists;

    public function __construct()
    {
        parent::__construct();
        $this->adminArtist = new AdminArtist();
        $this->arrayArtists = AdminArtist::convertArtistArrayForTwig(($this->adminArtist->getAllArtists()));
    }

    /*
     ************************
     *** HTTP method get  ***
     **********************+*
     */

    public function showAddArtist()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/artist/artist.add.admin.html.twig';
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showEditArtist()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/artist/artist.edit.admin.html.twig';
            self::$_twig->addGlobal("arrayArtists", $this->arrayArtists);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showDelArtist()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/artist/artist.delete.admin.html.twig';
            self::$_twig->addGlobal("arrayArtists", $this->arrayArtists);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    /*
     ************************
     *** HTTP method post ***
     ************************
     */

    public function insertNewArtist()
    {
        $firstName = $_POST['artist-firstname-add'];
        $lastname = $_POST['artist-lastname-add'];
        $birtdate = $_POST['artist-birthdate-add'];

        $this->adminArtist->insertArtist($lastname, $firstName, $birtdate);
        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/artist/add");
        die();    }

    public function editArtist()
    {
        $artistFirstNameNew = $_POST['artist-edit-firstname'];
        $artistdiLastNameNew = $_POST['artist-edit-lastname'];
        $artistBirthDateNew = $_POST['artist-edit-birthdate'];

        $artistId = $this->adminArtist->getArtistId($_POST['artist-edit-old']);
        $this->adminArtist->updateArtist($artistId, $artistdiLastNameNew, $artistFirstNameNew, $artistBirthDateNew);
        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/artist/edit");
        die();
    }

    public function deleteArtist()
    {
        $artistID = $this->adminArtist->getArtistId($_POST['artist-delete']);

        $test = $this->adminArtist->deleteArtist($artistID);

        if (!$test) {
            //TODO Add error page because the genre is associated with movie
            $httpVersion = $_SERVER['SERVER_PROTOCOL'];
            header("$httpVersion 500 Server error");
            die();
        }
        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/artist/delete");
        die();
    }

    /*
     ************************
     *** Internal method  ***
     **********************+*
     */

    public function getArtistDataJSON($id)
    {
        header("Content-Type: application/json");
        $arrayEnd = [];

        if ($this->adminArtist->artistExist($id)) {
            $artistData = $this->adminArtist->getArtisteData($id);

            $arrayEnd['firstname'] = $artistData['firstname_artist'];
            $arrayEnd['lastname'] = $artistData['lastname_artist'];
            $arrayEnd['birthdate'] = $artistData['birth_date'];

            echo json_encode($arrayEnd);
            die();
        }
        $httpVersion = $_SERVER['SERVER_PROTOCOL'];
        header("$httpVersion 404 Not Found");
        die();
    }
}
