<?php
namespace Kav\Blog\Base;

class Base
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    const CONFIG_PATH = __DIR__ . '/../../../../config.json';
    const ERR_CONFIG = 'Не найден файл конфигурации';
    private static $instance;
    private array $config;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getDateFormat()
    {
        return self::DATE_FORMAT;
    }

    public function getConfig(): array
    {
        if (!isset($this->config)) {
            $config = file_get_contents(self::CONFIG_PATH);
            if (!$config) {
                echo self::ERR_CONFIG;
                trigger_error(self::ERR_CONFIG, E_USER_ERROR);
            }
            $this->config = json_decode($config, true);
        }

        return $this->config;
    }
}
