<?php
namespace Kav\Blog\Model;

class User extends AbstractModel
{
    private string $name;
    private string $dateRegistered;
    private string $email;
    private string $password;

    public function __construct($id, $name, $dateRegistered, $email, $password)
    {
        $this->name = $name;
        $this->dateRegistered = $dateRegistered;
        $this->email = $email;
        $this->password = $password;
        parent::__construct($id);
    }
}