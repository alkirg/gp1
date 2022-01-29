<?php
namespace App\Controller;

use Kav\Blog\Controller\AbstractController;

class Blog extends AbstractController
{
    public function index()
    {
        if (!$this->user) {
            $this->redirect('/user/register');
        }

        return $this->view->render('Blog/index.php', [
//            'user' => $this->user
        ]);
    }
}