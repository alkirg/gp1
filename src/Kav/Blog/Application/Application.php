<?php
namespace Kav\Blog\Application;

use \Kav\Blog\Route\Route;
use \Kav\Blog\Route\RouteException;
use \Kav\Blog\Route\RedirectException;
use \Kav\Blog\View\View;
use \App\Model\User;

class Application implements ApplicationInterface
{
    const ERR_CONTROLLER = 'Не найден контроллер #CONTROLLER#';
    const ERR_ACTION = 'Не определено действие #ACTION# в классе #CLASS#';
    private $route;
    private $controller;
    private $actionName;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        try {
            session_start();
            $this->addRoutes();
            $this->initController();
            $this->initAction();

            $view = new View();
            $this->controller->setView($view);
            $this->initUser();

            $content = $this->controller->{$this->actionName}();

            echo $content;

        } catch (RedirectException $e) {
            header('Location: ' . $e->getUrl());
            die;
        } catch (RouteException $e) {
            $this->show404();
            header("HTTP/1.0 404 Not Found");
            echo $e->getMessage();
        }
    }

    private function show404()
    {

    }

    private function initUser()
    {
        $id = $_SESSION['id'] ?? null;
        if ($id) {
            $user = new User();
            $user = $user->getById($id);
            if ($user) {
                $this->controller->setUser($user);
            }
        }
    }

    private function addRoutes()
    {
        $this->route->addRoute('/', \App\Controller\Blog::class, 'index');
    }

    private function initController()
    {
        $controllerName = $this->route->getControllerName();
        if (!class_exists($controllerName)) {
            throw new RouteException(str_replace('#CONTROLLER#', $controllerName, self::ERR_CONTROLLER));
        }

        $this->controller = new $controllerName();
    }

    private function initAction()
    {
        $actionName = $this->route->getActionName();
        if (!method_exists($this->controller, $actionName)) {
            $message = str_replace('#ACTION#', $actionName, self::ERR_ACTION);
            $message = str_replace('#CLASS#', get_class($this->controller), $message);
            throw new RouteException($message);
        }

        $this->actionName = $actionName;
    }
}