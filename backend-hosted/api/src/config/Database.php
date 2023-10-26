<?php

class Database
{
    private static $connection;


    public function __construct(private array $config, private string $username, private string $password)
    {
    }

    public function getConnection(): PDO
    {
        $dsn = 'mysql:' .  http_build_query($this->config, "", ";");
        try {
            self::$connection = new PDO($dsn, $this->username, $this->password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return self::$connection;
    }
}
