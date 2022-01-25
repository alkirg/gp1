<?php
namespace Kav\Blog\Model;

interface ModelInterface
{
    public function get();
    public function add(array $fields);
    public function delete(int $id);
    public function update(array $fields);
}