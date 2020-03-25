<?php


abstract class AdminController extends Controller
{
    /** @var bool <b>TRUE</b> for safe mode, <b>FALSE</b> for unsafe mode. */
    private const SALT = true;
    protected $loginState = false;
    /** @var AdminUser */
    protected $adminUser;

    protected $userId = null;
    protected $userEmail = null;
    protected $userName = null;

    /** AdminController constructor. */
    public function __construct()
    {
        parent::__construct();
        $this->adminUser = new AdminUser();

        if (isset($_SESSION['loginState']) && $_SESSION['loginState']) {
            $this->userId = $_SESSION['userId'];
            $this->userEmail = $_SESSION['userEmail'];
            $this->userName = $_SESSION['userName'];
        }
    }

    /*
     ************************
     *** HTTP method get  ***
     ************************
     */

    public function showLoginPage()
    {
        $pageTwig = 'admin/login.admin.html.twig';
        echo $this->showPage($pageTwig);
    }

    /*
     ************************
     *** HTTP method post ***
     ************************
     */

    public function postLogIn()
    {
        if (isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
            $inputEmail = $_POST['inputEmail'];
            $inputPass = $_POST['inputPassword'];
            if ($this->adminUser->emailExist($inputEmail) && $this->checkPassword($inputEmail, $inputPass)) {
                $this->loginState = true;
                $this->userId = $this->adminUser->getUserID($inputEmail);
                $this->userEmail = $inputEmail;
                $this->userName = $this->adminUser->getUserName($this->userId);

                $_SESSION['loginState'] = $this->loginState;
                $_SESSION['userId'] = $this->userId;
                $_SESSION['userEmail'] = $this->userEmail;
                $_SESSION['userName'] = $this->userName;
            }
        }
        $this->redirectLogin();
    }

    /*
     ************************
     *** Internal method  ***
     **********************+*
     */

    /**
     * @param $inputEmail
     * @param $inputPassword
     * @return bool <b>TRUE</b> on sucess or <b>FALSE</b> on failure;
     */
    private function checkPassword($inputEmail, $inputPassword)
    {
        $userID = $this->adminUser->getUserID($inputEmail);

        $dbSaltedPass = $this->adminUser->getUserSaltedPasssord($userID);
        $dbPlainPass = $this->adminUser->getUserPlainPasssord($userID);

        if (self::SALT) {
            return password_verify($inputPassword, $dbSaltedPass);
        } else {
            return $inputPassword === $dbPlainPass;
        }
    }

    public function redirectLogin()
    {
        header('Location: ' . self::getBaseUrl() . '/admin');
        die('Redirect to LoginPage');
    }

    public function checkIfUserIsLogged()
    {
        return $this->loginState || (isset($_SESSION['loginState']) && $_SESSION['loginState']);
    }
}