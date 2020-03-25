<?php


/**
 * Class AdminGenreController
 */
class AdminGenreController extends AdminController
{
    /** @var $adminGenre AdminGenre */
    private $adminGenre;
    /** @var $arrayGenres array */
    private $arrayGenres;

    public function __construct()
    {
        parent::__construct();
        $this->adminGenre = new AdminGenre();
        $this->arrayGenres = Genre::convertGenreArrayForTwig($this->adminGenre->getAllGenres());
    }

    /*
     ************************
     *** HTTP method get  ***
     ************************
     */

    public function showAddGenre()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/genre/genre.add.admin.html.twig';
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showDelGenre()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/genre/genre.delete.admin.html.twig';
            self::$_twig->addGlobal('arrayGenres', $this->arrayGenres);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showEditGenre()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/genre/genre.edit.admin.html.twig';
            self::$_twig->addGlobal('arrayGenres', $this->arrayGenres);
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

    public function insertNewGenre()
    {
        $genre = $_POST['genre-add-new'];

        $this->adminGenre->insertGenre($genre);

        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/genre/add");
        die();
    }

    public function editGenre()
    {
        $genreOld = $_POST['genre-edit-old'];
        $genreNew = $_POST['genre-edit-new'];

        $genreID = $this->adminGenre->getGenreId($genreOld);
        $this->adminGenre->updateGenre($genreID, $genreNew);

        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/genre/edit");
        die();
    }

    public function deleteGenre()
    {
        $genre = $_POST['genre-delete'];

        $genreID = $this->adminGenre->getGenreId($genre);
        $test = $this->adminGenre->deleteGenre($genreID);

        $baseUrl = self::getBaseUrl();
        if (!$test) {
            //TODO Add error page because the genre is associated with movie
        }
        header("Location: $baseUrl/admin/genre/delete");
        die();
    }

    /*
     ************************
     *** Internal method  ***
     **********************+*
     */

    public function getGenreDataJSON($id)
    {
        header("Content-Type: application/json");
        if ($this->adminGenre->genreExist($id)) {
            $genreData = $this->adminGenre->getGenreById($id);

            echo json_encode($genreData);
            die();
        }
        header("HTTP/1.0 404 Not Found");
        die();
    }
}