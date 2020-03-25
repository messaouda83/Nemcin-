<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 */
class Controller
{
    private const CONFIG = __DIR__ . "/../core/config.json";
    protected static $_twig = null;
    protected static $_baseUrl = null;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        self::$_twig = self::getTwig();
    }

    /**
     * @return mixed|Environment|null
     */
    protected static function getTwig()
    {
        if (is_null(self::$_twig)) {
            $loader = new FilesystemLoader('Views');

            self::$_twig = new Environment($loader, [
                'debug' => true,
                'cache' => false
            ]);

            self::$_twig->addExtension(new DebugExtension());
            self::$_twig->addGlobal('baseUrl', self::getBaseUrl());
        }
        return self::$_twig;
    }

    /**
     * @return string
     */
    protected static function getBaseUrl()
    {
        if (is_null(self::$_baseUrl)) {
            $config = json_decode(file_get_contents(self::CONFIG));
            self::$_baseUrl = $config->baseUrl;
        }
        return self::$_baseUrl;
    }

    /**
     * @param $page
     * @return string Rendered HTML page
     */
    protected function showPage($page)
    {
        try {
            $template = self::$_twig->load($page);
            return $template->render();
        } catch (LoaderError $e) {
            die('Error LoaderError : ' . $e);
        } catch (RuntimeError $e) {
            die('Error RuntimeError : ' . $e);
        } catch (SyntaxError $e) {
            die('Error SyntaxError : ' . $e);
        }
    }
}
