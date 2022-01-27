<?php
require '../vendor/autoload.php';
use \Kav\Blog\Model\User;

$user = new User();
var_dump($user->fields());
$result = $user->add([
    'name' => 'Aleksandr',
    'email' => 'kav1@gde.ru',
    'password' => 'qwerty'
]);
var_dump($result);
echo '<br>';
$result = $user->getById(1);
var_dump($result);
$result = $user->update([
    'id' => 1,
    'password' => 'qwer1234'
]);
echo '<br>';
var_dump($result);
$result = $user->delete(3);
var_dump($result);
$result = $user->get();
echo '<pre>';
print_r($result);
echo '</pre>';
$result = $user->register([
    'email' => 'test112@test.tst',
    'name' => 'some name112',
    'password' => 'letitbe',
    'confirm_password' => 'letitbe'
]);
if ($result) {
    echo '<pre>';
    print_r($user->getById($result));
    echo '</pre>';
}
$result = $user->authorize('test112@test.tst', 'letitbe');
var_dump($result);