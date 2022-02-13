<?php
namespace App\Controller;

use Kav\Blog\Base\Base;
use Kav\Blog\Controller\AbstractController;
use App\Model\User as UserModel;
use App\Model\Message;
use Kav\Blog\Model\ModelException;

class Blog extends AbstractController
{
    const ERR_USER = 'Не указан пользователь';
    const ERR_USER_NOT_FOUND = 'Пользователь не найден';
    const ERR_MESSAGE_NOT_FOUND = 'Пост на найден';
    const ERR_POST_FILE = 'Файл не получен';
    const ERR_SAVE_FILE = 'Файл не сохранен';
    const UPLOAD_DIR = 'upload';

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
            (new Message())->add([
                'title' => $_POST['title'],
                'message' => $_POST['message'],
                'user_id' => $_SESSION['user'],
                'image' => isset($_FILES['image']) ? $this->saveFile($_FILES['image']) : ''
            ]);
            $this->redirect('/');
        }
        return $this->view->render('Blog/post.php');
    }

    private function saveFile(array $file): string
    {
        $result = self::UPLOAD_DIR . DIRECTORY_SEPARATOR . basename($file['name']);
        $file = file_get_contents($file['tmp_name']);
        if (!$file) {
            throw new \Exception(self::ERR_POST_FILE);
        }
        if (
            false === file_put_contents(
                $_SERVER['DOCUMENT_ROOT'] .
                    Base::getInstance()->getConfig()['folder'] .
                    DIRECTORY_SEPARATOR .
                    $result,
                $file
            )
        ) {
            throw new \Exception(self::ERR_SAVE_FILE);
        }
        return $result;
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