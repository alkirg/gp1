<?php
namespace App\Model;

use Kav\Blog\Model\AbstractModel;
use Kav\Blog\Base\Base;
use Kav\Blog\Base\Db;
use Kav\Blog\Model\ModelException;

class Message extends AbstractModel
{
    const TABLE_NAME = 'posts';
    const ERR_ID = 'Не указан id';
    const ERR_USER = 'Не указан пользователь';
    const ERR_TITLE = 'Не указан заголовок';
    const ERR_MESSAGE = 'Не указано сообщение';
    const POSTS_COUNT = 20;

    private string $message;
    private string $dateInsert;
    private int $userId;
    private string $image;

    public function __construct($args = [])
    {
        $this->message = $args['message'] ?? '';
        $this->dateInsert = $args['date_insert'] ?? '';
        $this->userId = $args['user_id'] ?? 0;
        $this->image = $args['image'] ?? '';
        parent::__construct($args['id'] ?? 0);
    }

    public function fields(): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'date_insert' => $this->dateInsert,
            'user_id' => $this->userId,
            'image' => $this->image
        ];
    }

    public function getLast($count = self::POSTS_COUNT)
    {
        return Db::getInstance()->fetchAll('SELECT message.id, message.title, message.message, message.date_insert, users.name as author FROM ' . $this->getTableName() . ' message INNER JOIN users on message.user_id = users.id ORDER BY date_insert desc LIMIT ' . $count);
    }

    public function getByUser(int $id, $count = false)
    {
        return Db::getInstance()->fetchAll('SELECT ' . $this->getPublicFields() . ' FROM ' . $this->getTableName() . ' WHERE `user_id` = :id ORDER BY date_insert desc' . ($count ? ' LIMIT ' . $count : ''), [':id' => $id]);
    }

    public function add(array $fields): int
    {
        $this->checkFields($fields);
        $db = Db::getInstance();
        $db->exec(
            'INSERT INTO ' . $this->getTableName() . '(user_id, message, date_insert, title, image) VALUES (:user_id, :message, :date_insert, :title, :image)',
            [
                ':title' => $fields['title'],
                ':user_id' => $fields['user_id'],
                ':message' => $fields['message'],
                ':image' => $fields['image'],
                ':date_insert' => $fields['date_insert'] ?? date(Base::getDateFormat()),
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

    private function checkFields(array $fields): bool
    {
        if (!$fields['user_id']) {
            throw new ModelException(self::ERR_USER);
        }
        if (!$fields['title']) {
            throw new ModelException(self::ERR_TITLE);
        }
        if (!$fields['message']) {
            throw new ModelException(self::ERR_MESSAGE);
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
}