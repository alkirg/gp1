<?php
namespace Kav\Blog\View;

interface ViewInterface
{
    public function render(string $template, $data = []);
}