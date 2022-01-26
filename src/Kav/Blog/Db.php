<?php
namespace Kav\Blog;

class Db
{
    const CONFIG_PATH = __DIR__ . '/../../../config.json';
    const ERR_CONFIG = 'Не найден файл конфигурации';
    const ERR_QUERY = 'Неизвестная ошибка запроса';

    private static $instance;
    /** @var \PDO */
    private $pdo;
    private array $config;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getConfig()
    {
        $config = file_get_contents(self::CONFIG_PATH);
        if (!$config) {
            echo self::ERR_CONFIG;
            trigger_error(self::ERR_CONFIG, E_USER_ERROR);
        }
        $this->config = json_decode($config, true);
        return true;
    }

    private function connect()
    {
        if (!$this->pdo) {
            $this->getConfig();
            $this->pdo = new \PDO('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['dbname'], $this->config['user'], $this->config['password'], [\PDO::MYSQL_ATTR_FOUND_ROWS => true]); // https://www.php.net/manual/ru/pdostatement.rowcount.php чтобы update считал точно количество найденных строк
        }

        return $this->pdo;
    }

    public function lastInsertId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    public function exec(string $query, array $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $result = $query->execute($params);

        if (!$result) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            } else {
                trigger_error(self::ERR_QUERY);
            }
            return false;
        }

        return $query->rowCount();
    }

    public function fetchAll(string $query, array $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $result = $query->execute($params);

        if (!$result) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            } else {
                trigger_error(self::ERR_QUERY);
            }
            return false;
        }

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function fetch(string $query, array $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $result = $query->execute($params);

        if (!$result) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            } else {
                trigger_error(self::ERR_QUERY);
            }
            return false;
        }

        return $query->fetch($this->pdo::FETCH_ASSOC);
    }
}