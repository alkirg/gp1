<?php
namespace Kav\Blog\Model;
use Kav\Blog\Db;

abstract class AbstractModel implements ModelInterface
{
    protected int $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    abstract protected function getTableName();
    abstract protected function getPublicFields();

    public function get()
    {
        return Db::getInstance()->fetchAll('SELECT ' . $this->getPublicFields() . ' FROM ' . $this->getTableName());
    }

    public function getById(int $id)
    {
        return Db::getInstance()->fetch('SELECT ' . $this->getPublicFields() . ' FROM ' . $this->getTableName() . ' WHERE `id` = :id', [':id' => $id]);
    }

    public function delete(int $id): bool
    {
        return Db::getInstance()->exec('DELETE FROM ' . $this->getTableName() . ' WHERE `id` = :id', [':id' => $id]);
    }

    protected function generateUpdateQuery(array &$fields)
    {
        $result = '';
        $newFields = [];
        if ($fields['id']) {
            $newFields[':id'] = $fields['id'];
            unset($fields['id']);
        }
        foreach ($fields as $field => $value) {
            $result .= '`' . $field . '` = :' . $field;
            $newFields[':' . $field]  = $value;
        }
        $fields = $newFields;
        return $result;
    }
}