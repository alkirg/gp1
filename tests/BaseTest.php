<?php
require '../vendor/autoload.php';

use \Kav\Blog\Base\Base;
$config = Base::getInstance()->getConfig();
echo '<pre>';
print_r($config);
echo '</pre>';