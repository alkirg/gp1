<?php
namespace Kav\Blog\Model;

abstract class AbstractModel implements ModelInterface
{
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
}