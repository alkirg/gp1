<?php
namespace Kav\Blog\Model;
use Kav\Blog\Db;

abstract class AbstractModel implements ModelInterface
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract protected function getTableName();

    public function get()
    {
        return Db::getInstance()->fetchAll('SELECT * FROM ' . $this->getTableName());
    }

    public function getById(int $id)
    {
        return Db::getInstance()->fetch('SELECT * FROM ' . $this->getTableName() . ' WHERE `id` = :id', [':id' => $id]);
    }

    public function delete(int $id): bool
    {
        return Db::getInstance()->exec('DELETE FROM ' . $this->getTableName() . ' WHERE `id` = :id', [':id' => $id]);
    }
}