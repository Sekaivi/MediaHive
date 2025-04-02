<?php

require_once __DIR__ . '/../config/Translation.php';

class BaseController {
    protected $t; // translation will be stored inside

    public function __construct() {
        $this->t = Translation::getInstance(); 
    }
}
