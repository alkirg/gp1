<?php
namespace App\Controller;

use Kav\Blog\Controller\AbstractController;
use App\Model\User as UserModel;

class User extends AbstractController
{
    public function login()
    {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            try {
                $user = (new UserModel())->authorize($_POST['login'], $_POST['password']);
                if ($user) {
                    $_SESSION['user'] = $user['id'];
                }
                return $this->view->render('User/login.php', ['user' => $user]);
            } catch(\Exception $exception) {
                return $this->view->render('User/login.php', ['error' => $exception->getMessage()]);
            }
        }
        return $this->view->render('User/login.php');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/user/login');
    }

    public function register()
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
            try {
                $user = (new UserModel())->register([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password']
                ]);
                if ($user) {
                    $_SESSION['user'] = $user;
                }
                return $this->view->render('User/register.php', [
                    'user' => (new UserModel())->getById($user)
                ]);
            } catch(\Exception $exception) {
                return $this->view->render('User/register.php', [
                    'error' => $exception->getMessage()
                ]);
            }
        }
        return $this->view->render('User/register.php');
    }
}