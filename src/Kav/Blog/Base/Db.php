<?php
namespace Kav\Blog\Base;

class Db
{
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

    private function connect()
    {
        if (!$this->pdo) {
            $this->config = Base::getInstance()->getConfig();
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