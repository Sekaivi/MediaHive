<?php

class Model{
    protected $cnxDB ;
    public function __construct($cnxDB){
        $this->cnxDB = $cnxDB ;
      }
}

?>