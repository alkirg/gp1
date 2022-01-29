<?php
namespace Kav\Blog\Controller;

use \Kav\Blog\View\AbstractView;

abstract class AbstractController implements ControllerInterface
{
    protected $view;

    protected function redirect(string $url)
    {
        throw new RedirectException($url);
    }

    public function setView(AbstractView $view): void
    {
        $this->view = $view;
    }
}