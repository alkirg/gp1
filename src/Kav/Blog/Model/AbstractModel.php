<?php
namespace Kav\Blog\Model;

abstract class AbstractModel implements ModelInterface
{
    const ERR_USER_ID = 'ID пользователя должен быть больше 0';

    protected int $id;

    public function __construct(int $id)
    {
        if ($this->isPositive($id)) {
            $this->id = $id;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    protected function isPositive($number): bool
    {
        if ($number <= 0) {
            trigger_error(self::ERR_USER_ID, E_USER_ERROR);
            die;
        }
        return true;
    }
}