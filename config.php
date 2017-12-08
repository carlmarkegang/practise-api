<?php
$controllerPages = array(
    'pages' =>  ['home', 'error'],
    'posts' =>  ['index', 'show', 'createpost', 'deletepost', 'editpost', 'loadpost'],
    'user'  =>  ['index', 'logout', 'createuser', 'view']
);
$controllerPagesSkipLayout = array(
    'posts' =>  ['loadpost']
);

$postLimit = 10;
$userPostLimit = 5;






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

