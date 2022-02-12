<?php
require '../vendor/autoload.php';

use App\Model\Message;

var_dump((new Message())->get());
die;
$message = new Message();
var_dump($message->fields());
//$result = $message->add([
//    'message' => 'test4',
//    'date_insert' => date('Y-m-d H:i:s'),
//    'user_id' => 1
//]);
//$result = $message->add([
//    'message' => 'test5',
//    'date_insert' => date('Y-m-d H:i:s'),
//    'user_id' => 1
//]);
//var_dump($result);
echo '<br>';
$result = $message->getById(1);
var_dump($result);
$result = $message->update([
   'id' => 1,
   'message' => 'test2'
]);
echo '<br>';
var_dump($result);
$result = $message->delete(2);
var_dump($result);
$result = $message->get();
echo '<pre>';
print_r($result);
echo '</pre>';