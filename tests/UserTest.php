<?php
require '../vendor/autoload.php';
use \Kav\Blog\Model\User;

$user = new User();
var_dump($user->fields());
//$result = $user->add([
//    'name' => 'Aleksandr',
//    'date_insert' => date('Y-m-d H:i:s'),
//    'email' => 'kav1@gde.ru',
//    'password' => 'qwerty'
//]);
//var_dump($result);
echo '<br>';
$result = $user->getById(1);
var_dump($result);
$result = $user->update([
    'id' => 1,
    'password' => 'qwer1234'
]);
echo '<br>';
var_dump($result);
$result = $user->delete(2);
var_dump($result);
$result = $user->get();
echo '<pre>';
print_r($result);
echo '</pre>';