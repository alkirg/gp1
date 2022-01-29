<?php
namespace Kav\Blog\View;
use \Kav\Blog\Base\Base;

abstract class AbstractView implements ViewInterface
{
    private string $templatePath;
    private array $data;

    public function __construct()
    {
        $this->templatePath = Base::getInstance()->getConfig()['root'] . DIRECTORY_SEPARATOR . 'app/View';
    }

    public function render(string $template, $data = [])
    {
        $this->data += $data;
        ob_start();
        include $this->templatePath . DIRECTORY_SEPARATOR . $template;
        return ob_get_clean();
    }
}