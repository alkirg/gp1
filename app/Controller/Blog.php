<?php
namespace App\Controller;

use Kav\Blog\Controller\AbstractController;
use App\Model\User as UserModel;
use App\Model\Message;

class Blog extends AbstractController
{
    public function index()
    {
        if ($_SESSION['user']) {
            $this->user = (new UserModel())->getById($_SESSION['user']);
        } else {
            $this->redirect('/user/login');
        }

        return $this->view->render('Blog/index.php', [
            'user' => $this->user,
            'posts' => (new Message())->getByUser($this->user['id'])
        ]);
    }
}