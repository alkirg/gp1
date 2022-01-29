<?php
namespace App\Model;

use Kav\Blog\Base\Base;
use Kav\Blog\Base\Db;
use Kav\Blog\Model\AbstractModel;
use Kav\Blog\Model\ModelException;

class User extends AbstractModel
{
    const TABLE_NAME = 'users';
    const ERR_NAME = 'Не указано имя';
    const ERR_EMAIL = 'Не указана почта';
    const ERR_PASSWORD = 'Не указан пароль';
    const ERR_PASSWORD_CONFIRM = 'Пароли не совпадают';
    const ERR_LOGIN = 'Логин или пароль указаны неверно';
    const ERR_ID = 'Не указан id';
    const SALT = 'fqoijw1823ur';

    private string $name;
    private string $dateInsert;
    private string $email;
    private string $password;

    public function __construct($args = [])
    {
        $this->name = $args['name'] ?? '';
        $this->dateInsert = $args['date_insert'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        parent::__construct($args['id'] ?? 0);
    }

    public function fields(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_insert' => $this->dateInsert,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function getByEmail(string $email)
    {
        return Db::getInstance()->fetch('SELECT ' . $this->getPublicFields() . ' FROM ' . $this->getTableName() . ' WHERE email = :email', [':email' => $email]);
    }

    public function add(array $fields): int
    {
        $this->checkFields($fields);
        $user = $this->getByEmail($fields['email']);
        if (is_array($user)) {
            return false;
        }
        $db = Db::getInstance();
        $db->exec(
            'INSERT INTO ' . $this->getTableName() . '(`name`, email, date_insert, `password`) VALUES (:name, :email, :date_insert, :password)',
            [
                ':name' => $fields['name'],
                ':email' => $fields['email'],
                ':date_insert' => $fields['date_insert'] ?? date(Base::getDateFormat()),
                ':password' => $this->generatePasswordHash($fields['password'])
            ]
        );
        return $db->lastInsertId();
    }

    public function update(array $fields): bool
    {
        if (!$fields['id']) {
            throw new ModelException(self::ERR_ID);
        }
        return Db::getInstance()->exec(
            'UPDATE ' . $this->getTableName() . ' SET ' . $this->generateUpdateQuery($fields) . ' WHERE id = :id',
            $fields
        );
    }

    public function register(array $fields)
    {
        $this->checkFields($fields);
        if ($fields['password'] !== $fields['confirm_password']) {
            throw new ModelException(self::ERR_PASSWORD_CONFIRM);
        }
        return $this->add([
           'name' => $fields['name'],
           'email' => $fields['email'],
           'password' => $fields['password']
        ]);
    }

    public function authorize(string $login, string $password)
    {
        $user = $this->getByEmail($login);
        if (!$user || $user['password'] !== $this->generatePasswordHash($password)) {
            throw new ModelException(self::ERR_LOGIN);
        }
        return $user;
    }

    private function checkFields(array $fields): bool
    {
        if (!$fields['name']) {
            throw new ModelException(self::ERR_NAME);
        }
        if (!$fields['email']) {
            throw new ModelException(self::ERR_EMAIL);
        }
        if (!$fields['password']) {
            throw new ModelException(self::ERR_PASSWORD);
        }

        return true;
    }

    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    protected function getPublicFields()
    {
        return '*';
    }

    public function generatePasswordHash($password)
    {
        return sha1($password . self::SALT);
    }
}