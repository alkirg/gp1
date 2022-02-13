<?php
namespace App\Model;

use Kav\Blog\Base\Base;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail
{
    const ERR_CONFIG = 'Ошибка конфигурации почты';
    private static $instance;
    private array $config = [];

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getConfig()
    {
        if (!$this->config) {
            $config = Base::getInstance()->getConfig();
            if (
                !$config['smtp_server'] ||
                !$config['smtp_port'] ||
                !$config['smtp_user'] ||
                !$config['smtp_password']
            ) {
                throw new \Exception(self::ERR_CONFIG);
            }
            $this->config = [
                'server' => $config['smtp_server'],
                'port' => $config['smtp_port'],
                'user' => $config['smtp_user'],
                'password' => $config['smtp_password'],
                'encryption' => $config['smtp_encryption']
            ];
        }
        return $this->config;
    }

    public function send(array $to, string $subject, string $message)
    {
        $this->getConfig();
        $transport = (new Swift_SmtpTransport($this->config['server'], $this->config['port']))
            ->setUsername($this->config['user'])
            ->setPassword($this->config['password'])
        ;
        if ($this->config['encryption']) {
            $transport->setEncryption($this->config['encryption']);
        }

        $mailer = new Swift_Mailer($transport);

        $msg = (new Swift_Message($subject))
            ->setFrom([$this->config['user'] => $this->config['user']])
            ->setTo($to)
            ->setBody($message)
        ;

        return $mailer->send($msg);
    }
}