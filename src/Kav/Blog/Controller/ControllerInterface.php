<?php
namespace Kav\Blog\Controller;

use Kav\Blog\View\View;

interface ControllerInterface
{
    public function setView(View $view);
}