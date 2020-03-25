<?php

/**
 * Class HomeController
 */
class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        self::$_twig = parent::getTwig();
    }

    public function showHome()
    {
        echo $this->showPage('home.html.twig');
    }
}
