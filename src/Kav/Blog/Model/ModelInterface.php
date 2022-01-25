<?php
namespace Kav\Blog\Model;

interface ModelInterface
{
    public function get();
    public function add();
    public function delete();
    public function update();
}