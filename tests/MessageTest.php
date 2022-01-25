<?php
require_once '../src/Kav/Blog/Db.php';
require_once '../src/Kav/Blog/Model/ModelInterface.php';
require_once '../src/Kav/Blog/Model/AbstractModel.php';
require_once '../src/Kav/Blog/Model/Message.php';
use \Kav\Blog\Model\Message;

$message = new Message();
var_dump($message->fields());
//$result = $message->add([
//    'message' => 'test',
//    'date_insert' => date('Y-m-d H:i:s'),
//    'user_id' => 1
//]);
//var_dump($result);
echo '<br>';
$result = $message->getById(1);
var_dump($result);
$result = $message->update([
   'id' => 1,
   'message' => 'asdfasdf'
]);
echo '<br>';
var_dump($result);