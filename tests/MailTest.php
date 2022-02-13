<?php
require '../vendor/autoload.php';
use App\Model\Mail;

//$result = Mail::getInstance()->send(['kav@gde.ru'], 'test', 'test msg');
//if ($result) {
//    echo 'Сообщение отправлено';
//}
$result = Mail::getInstance()->send(['kavgde.ru'], '', 'test msg');
if ($result) {
    echo 'Сообщение отправлено';
}