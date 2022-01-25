<?php
require_once '../src/Kav/Blog/Db.php';
use Kav\Blog\Db;

//$q = 'INSERT INTO users(`name`, phone, email) VALUES (:name, :phone, :email)';
//$db = Db::getInstance();
//$db->exec($q, [':name' => 'test', ':phone' => '12341234', ':email' => 'kav@gde.ru']);
//$q = 'INSERT INTO users(`name`, phone, email) VALUES (:name, :phone, :email)';
//$db = Db::getInstance();
//$db->exec($q, [':name' => 'test2', ':phone' => '43434', ':email' => 'test@example.com']);

//error_reporting(0);

$q = 'SELECT * FROM users';
$db = Db::getInstance();
var_dump($db->fetchAll($q));

trigger_error('test', E_USER_ERROR);
echo 'sms';

//$q = 'SELECT * FROM users WHERE `id` = 2';
//$db = Db::getInstance();
//var_dump($db->fetch($q));

//$q = 'SELECT * FROM userds WHERE `id` = 2';
//$db = Db::getInstance();
//var_dump($db->fetch($q));