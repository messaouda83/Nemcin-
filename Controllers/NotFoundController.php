<?php


class NotFoundController extends Controller
{
    public function showNotFound($request)
    {
        header("HTTP/1.0 404 Not Found");
        $pageTwig = '404.html.twig';

        self::$_twig->addGlobal("request", html_entity_decode($request));
        echo $this->showPage($pageTwig);
    }
}