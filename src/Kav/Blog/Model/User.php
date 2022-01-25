<?php
namespace Kav\Blog\Model;
use \Kav\Blog\Db;

class User extends AbstractModel
{
    const TABLE_NAME = 'users';
    const ERR_NAME = 'Не указано имя';
    const ERR_EMAIL = 'Не указана почта';
    const ERR_PASSWORD = 'Не указан пароль';
    const ERR_ID = 'Не указан id';

    private string $name;
    private string $dateInsert;
    private string $email;
    private string $password;

    public function __construct($id, $name, $dateInsert, $email, $password)
    {
        $this->name = $name;
        $this->dateInsert = $dateInsert;
        $this->email = $email;
        $this->password = $password;
        parent::__construct($id);
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
        return Db::getInstance()->fetch('SELECT ' . $this->getPublicFields . ' FROM ' . $this->getTableName() . ' WHERE email = :email', [':email' => $email]);
    }

    public function add(array $fields): int
    {
        $this->checkFields($fields);
        $user = $this->getByEmail($fields['email']);
        if (is_array($user)) {
            return $user['id'];
        }
        $db = Db::getInstance();
        $db->exec(
            'INSERT INTO ' . $this->getTableName() . '(`name`, email, date_insert, `password`) VALUES (:name, :email, :date_insert, :password)',
            [
                ':name' => $fields['name'],
                ':email' => $fields['email'],
                ':date_insert' => $fields['date_insert'],
                ':password' => $fields['password']
            ]
        );
        return $db->lastInsertId();
    }

    public function update(array $fields): bool
    {
        if (!$fields['id']) {
            trigger_error(self::ERR_ID, E_USER_ERROR);
        }
        $this->checkFields($fields);
        return Db::getInstance()->exec(
            'UPDATE ' . $this->getTableName() . ' SET `name` = :name, email = :email, date_insert = :date_insert, `password` = :password WHERE `id` = :id',
            [
                ':name' => $fields['name'],
                ':email' => $fields['email'],
                ':date_insert' => $fields['date_insert'],
                ':password' => $fields['password'],
                ':id' => $fields['id']
            ]
        );
    }

    private function checkFields(array $fields): bool
    {
        if (!$fields['name']) {
            trigger_error(self::ERR_NAME, E_USER_ERROR);
        }
        if (!$fields['email']) {
            trigger_error(self::ERR_EMAIL, E_USER_ERROR);
        }
        if (!$fields['password']) {
            trigger_error(self::ERR_PASSWORD, E_USER_ERROR);
        }

        return true;
    }

    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    protected function getPublicFields()
    {
        return '`id`, `name`, email, date_insert';
    }
}