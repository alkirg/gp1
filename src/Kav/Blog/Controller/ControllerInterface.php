<?php
namespace Kav\Blog\Controller;

use Kav\Blog\View\AbstractView;

interface ControllerInterface
{
    public function setView(AbstractView $view);
}