<?php

namespace Portfolio\Model;

use PDO;
use Portfolio\Entity\User;
use Portfolio\Model\Database;

class AccountManager extends Database
{
    private $table = "users";

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
