<?php
namespace Kav\Blog\Controller;

use App\Model\User as UserModel;
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

    public function checkAuth()
    {
        if ($this->user) {
            return $this->user;
        }
        if ($_SESSION['user']) {
            $this->user = (new UserModel())->getById($_SESSION['user']);
            return $this->user;
        }
        $this->redirect('/user/login');
    }
}