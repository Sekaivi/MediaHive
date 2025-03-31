<<<<<<< HEAD
<?php

require_once __DIR__ . '/../config/Translation.php';

class BaseController {
    protected $t; // translation will be stored inside

    public function __construct() {
        $this->t = Translation::getInstance(); 
    }
}
=======
<?php

require_once __DIR__ . '/../config/Translation.php';

class BaseController {
    protected $t; // translation will be stored inside

    public function __construct() {
        $this->t = Translation::getInstance(); 
    }
}
>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
