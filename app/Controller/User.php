<?php
namespace App\Controller;

use Kav\Blog\Controller\AbstractController;
use App\Model\User as UserModel;

class User extends AbstractController
{
    public function register()
    {
        return $this->view->render('User/register.php');
    }
}