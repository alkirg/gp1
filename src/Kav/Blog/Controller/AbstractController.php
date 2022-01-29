<?php
namespace Kav\Blog\Controller;

use Kav\Blog\Base\Base;
use Kav\Blog\Route\RedirectException;
use Kav\Blog\View\View;

abstract class AbstractController implements ControllerInterface
{
    protected $view;
    protected $user;

    protected function redirect(string $url)
    {
        throw new RedirectException(Base::getInstance()->getConfig()['folder'] . $url);
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }
}