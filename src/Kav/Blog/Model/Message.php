<?php
namespace Kav\Blog\Model;

class Message extends AbstractModel
{
    private string $message;
    private string $date;
    private int $userId;

    public function __construct($id, $message, $date, $userId)
    {
        $this->message = $message;
        $this->date = $date;
        $this->userId = $userId;
        parent::__construct($id);
    }
}