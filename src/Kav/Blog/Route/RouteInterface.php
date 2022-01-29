<?php
namespace Kav\Blog\Route;

interface RouteInterface
{
    public function getControllerName();
    public function getActionName();
}