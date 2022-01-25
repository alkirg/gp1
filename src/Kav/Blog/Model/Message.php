<?php
namespace Kav\Blog\Model;
use Kav\Blog\Db;

class Message extends AbstractModel
{
    const TABLE_NAME = 'posts';
    const ERR_ID = 'Не указан id';
    const ERR_USER = 'Не указан пользователь';
    const ERR_MESSAGE = 'Не указано сообщение';

    private string $message;
    private string $dateInsert;
    private int $userId;

    public function __construct($id, $message, $dateInsert, $userId)
    {
        $this->message = $message;
        $this->dateInsert = $dateInsert;
        $this->userId = $userId;
        parent::__construct($id);
    }

    public function fields(): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'date_insert' => $this->dateInsert,
            'user_id' => $this->userId
        ];
    }

    public function add(array $fields): int
    {
        $this->checkFields($fields);
        $db = Db::getInstance();
        $db->exec(
            'INSERT INTO ' . self::TABLE_NAME . '(user_id, message, date_insert) VALUES (:user_id, :message, :date_insert)',
            [
                ':user_id' => $fields['user_id'],
                ':message' => $fields['message'],
                ':date_insert' => $fields['date_insert'],
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
            'UPDATE users SET user_id = :user_id, message = :message, date_insert = :date_insert WHERE `id` = :id',
            [
                ':user_id' => $fields['user_id'],
                ':message' => $fields['message'],
                ':date_insert' => $fields['date_insert'],
                ':id' => $fields['id']
            ]
        );
    }

    private function checkFields(array $fields): bool
    {
        if (!$fields['user_id']) {
            trigger_error(self::ERR_USER, E_USER_ERROR);
        }
        if (!$fields['message']) {
            trigger_error(self::ERR_MESSAGE, E_USER_ERROR);
        }

        return true;
    }

    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}