<?php 

namespace App\Business;

trait Business{

    private $repository;

    public function __construct(){
        $class = '\App\Models\\' . str_replace('App\Business\\', '', get_class($this));
        if (class_exists($class)) {
            $this->repository = new $class();
        }
    }
}
