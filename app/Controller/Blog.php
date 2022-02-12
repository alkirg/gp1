<?php
namespace App\Controller;

use Kav\Blog\Controller\AbstractController;
use App\Model\User as UserModel;
use App\Model\Message;
use Kav\Blog\Model\ModelException;

class Blog extends AbstractController
{
    const ERR_USER = 'Не указан пользователь';
    const ERR_USER_NOT_FOUND = 'Пользователь не найден';
    const ERR_MESSAGE_NOT_FOUND = 'Пост на найден';

    public function index()
    {
        $this->user = $this->checkAuth();
        return $this->view->render('Blog/index.php', [
            'user' => $this->user,
            'posts' => (new Message())->getByUser($this->user['id']),
            'admin' => isset($this->user['admin'])
        ]);
    }

    public function post()
    {
        $this->checkAuth();
        if (isset($_POST['title']) && isset($_POST['message'])) {
            try {
                $message = (new Message())->add([
                    'title' => $_POST['title'],
                    'message' => $_POST['message'],
                    'user_id' => $_SESSION['user']
                ]);
            } catch(\Exception $exception) {
                return $this->view->render('Blog/post.php', ['error' => $exception->getMessage()]);
            } finally {
                $this->redirect('/');
            }
        }
        return $this->view->render('Blog/post.php');
    }

    public function posts()
    {
        $this->checkAuth();
        return $this->view->render('Blog/posts.php', [
            'posts' => (new Message())->getLast(),
            'admin' => (new UserModel())->isAdmin($_SESSION['user'])
        ]);
    }

    public function delete()
    {
        $this->checkAuth();
        if (!(new UserModel())->isAdmin($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => self::ERR_MESSAGE_NOT_FOUND]);
            return;
        }
        if (isset($_GET['id'])) {
            try {
                $result = (new Message())->delete(intval($_GET['id']));
                if (!$result) {
                    throw new ModelException(self::ERR_MESSAGE_NOT_FOUND);
                } else {
                    echo json_encode(['success' => true]);
                }
            } catch (\Exception $exception) {
                echo json_encode(['success' => false, 'message' => $exception->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => self::ERR_MESSAGE_NOT_FOUND]);
        }
    }

    public function userPosts(int $userId, int $count)
    {
        echo json_encode(['success' => true, 'data' => (new Message())->getByUser($userId, $count)]);
    }
}