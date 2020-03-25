<?php

/**
 * Class AdminHomeController
 */
class AdminHomeController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function showHomeAdmin()
    {
        if ($this->checkIfUserIsLogged()) {
            self::$_twig->addGlobal('userName', $this->userName);
            $pageTwig = 'admin/home.admin.html.twig';
            echo $this->showPage($pageTwig);
        } else {
            echo $this->showLoginPage();
        }
    }
}

