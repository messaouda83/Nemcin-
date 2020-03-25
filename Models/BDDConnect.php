<?php

/**
 * Class BDDConnect
 */
abstract class BDDConnect
{
    private const CONFIG = __DIR__ . '/../core/config.json';
    private const OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    /**
     * PDO Object initiated by fetPdo() or null if error/not initialized
     * @var PDO|null
     */
    protected static $_pdo = null;

    /**
     * Return a static PDO object for all it's children classes
     * @return PDO|null $_pdo
     */
    protected static function getPdo()
    {
        if (is_null(self::$_pdo)) {
            $config = json_decode(file_get_contents(self::CONFIG));
            try {
                self::$_pdo = new PDO($config->dsn, $config->user, $config->psswd, self::OPTIONS);
            } catch (PDOException $e) {
                die('Error : ' . $e->getMessage());
            }
        }
        return self::$_pdo;
    }
}