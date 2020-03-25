<?php


/**
 * Class AdminMovieController
 */
class AdminMovieController extends AdminController
{
    const AUTHORIZEDFILESTYPES = [
        'image/jpeg',
        'image/png',
        'image/tiff'
    ];
    /** @var $adminMovie AdminMovie */
    private $adminMovie;
    private $arrayArtists;
    /** @var AdminMovie */
    private $adminGenre;
    /** @var AdminMovie */
    private $adminArtist;

    /** @var $arrayMovies array */
    private $arrayMovies;
    private $arrayGenres;

    public function __construct()
    {
        parent::__construct();
        $this->adminMovie = new AdminMovie();
        $this->adminGenre = new AdminGenre();
        $this->adminArtist = new AdminArtist();
        $this->arrayMovies = Movie::convertMovieArrayForTwig($this->adminMovie->getAllMovies());
        $this->arrayGenres = Genre::convertGenreArrayForTwig($this->adminGenre->getAllGenres());
        $this->arrayArtists = AdminArtist::convertArtistArrayForTwig(($this->adminArtist->getAllArtists()));
    }

    /*
     ************************
     *** HTTP method get  ***
     **********************+*
     */

    public function showAddMovie()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/movie/movie.add.admin.html.twig';
            self::$_twig->addGlobal('arrayGenres', $this->arrayGenres);
            self::$_twig->addGlobal("arrayArtists", $this->arrayArtists);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showEditMovie()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/movie/movie.edit.admin.html.twig';
            self::$_twig->addGlobal('arrayMovies', $this->arrayMovies);
            self::$_twig->addGlobal('arrayGenres', $this->arrayGenres);
            self::$_twig->addGlobal("arrayArtists", $this->arrayArtists);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function showDelMovie()
    {
        if ($this->checkIfUserIsLogged()) {
            $pageTwig = 'admin/movie/movie.delete.admin.html.twig';
            self::$_twig->addGlobal('arrayMovies', $this->arrayMovies);
            echo $this->showPage($pageTwig);
        } else {
            $this->redirectLogin();
        }
    }

    public function getMovieDataJSON($id)
    {
        header("Content-Type: application/json");
        $arrayEnd = [];

        if ($this->adminMovie->movieExist($id)) {
            $movieData = $this->adminMovie->getMovieById($id);

            $arrayEnd['title'] = $movieData['title'];
            $arrayEnd['genre'] = $movieData['genre_id'];
            $arrayEnd['year'] = $movieData['release_year'];
            $arrayEnd['director'] = $movieData['director_id'];
            $arrayEnd['poster'] = $movieData['poster'];
            $arrayEnd['synopsis'] = $movieData['synopsis'];

            echo json_encode($arrayEnd);
            die();
        }
        header("HTTP/1.0 404 Not Found");
        die();
    }

    /*
     ************************
     *** HTTP method post ***
     ************************
     */

    public function insertNewMovie()
    {
        $title = $_POST['movie-title-add'];
        $genreID = $_POST['movie-genre-add'];
        $directorID = $_POST['movie-director-add'];
        $year = $_POST['movie-year-add'];
        $synopsis = $_POST['movie-synopsis-add'];

        $poster = $_FILES['movie-poster-add'];

        if (is_uploaded_file($poster['tmp_name'])) {
            if (in_array($poster['type'], self::AUTHORIZEDFILESTYPES)) {
                if (move_uploaded_file($poster['tmp_name'], 'Uploads/posters/' . $poster['name'])) {
                    if ($this->adminMovie->insertMovie($title, $year, $poster['name'], $synopsis, $genreID, $directorID)) {
                        $baseUrl = self::getBaseUrl();
                        header("Location: $baseUrl/admin/movie/add");
                        die();
                    }
                }
            }
        }
        //TODO Add error page
        $httpVersion = $_SERVER['SERVER_PROTOCOL'];
        header("$httpVersion 500 Server error");
        die();
    }

    public function editMovie()
    {
        $movieID = $_POST['movie-title-old'];

        $title = $_POST['movie-title-new'];
        $genreID = $_POST['movie-genre-new'];
        $directorID = $_POST['movie-director-new'];
        $year = $_POST['movie-year-new'];
        $synopsis = $_POST['movie-synopsis-new'];

        $poster = $_FILES['movie-poster-new'];

        if ($poster['error'] === 4) {
            $posterName = $this->adminMovie->getMovieById($movieID)['poster'];
        } else {
            $posterName = $poster['name'];
            if (is_uploaded_file($poster['tmp_name'])) {
                if (in_array($poster['type'], self::AUTHORIZEDFILESTYPES)) {
                    if (!move_uploaded_file($poster['tmp_name'], 'Uploads/posters/' . $posterName)) {
                        //TODO Add error page
                        $httpVersion = $_SERVER['SERVER_PROTOCOL'];
                        header("$httpVersion 500 Server error");
                        die();
                    }
                }
            }
        }
            if ($this->adminMovie->updateMovie($movieID, $title, $year, $posterName, $synopsis, $genreID, $directorID)) {
                $baseUrl = self::getBaseUrl();
                header("Location: $baseUrl/admin/movie/edit");
                die();
            }
        //TODO Add error page
        $httpVersion = $_SERVER['SERVER_PROTOCOL'];
        header("$httpVersion 500 Server error");
        die();
    }

    public function deleteMovie()
    {
        var_dump($_POST);

        $movieID = $_POST['movie-delete'];
        $test = $this->adminMovie->deleteMovie($movieID);

        if (!$test) {
            //TODO Add error page because the genre is associated with movie
            $httpVersion = $_SERVER['SERVER_PROTOCOL'];
            header("$httpVersion 500 Server error");
            die();
        }
        $baseUrl = self::getBaseUrl();
        header("Location: $baseUrl/admin/movie/delete");
        die();
    }

}