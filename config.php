<?php

class db extends Mysqli
{
    protected $db;

    public function __construct()
    {
        parent::__construct("localhost", "username", "password", "backend");
        $this->getConnectError();
    }


    public function getConnectError()
    {
        if ($this->connect_error) {
            echo $this->connect_error;
        }

    }


}
