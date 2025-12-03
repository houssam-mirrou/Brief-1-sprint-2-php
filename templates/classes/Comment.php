<?php

class Comment {
    public $name;
    public $email;
    public $description;
    public function __construct($name,$email,$description)
    {   
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
    }
}

$temp = new comment("hey","houssam@gmail.com","sudfhgosdf");