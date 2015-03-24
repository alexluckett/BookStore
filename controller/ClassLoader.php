<?php

/**
 * Proxy to load a class, so as to not introduce global state in the action factory.
 * 
 * Ensures invidivual action classes are not instantiated until required.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ClassLoader {
    
    private $className;
    private $permissionLevel;
    
    public function __construct($className, $permissionLevel) {
        if(strlen($className) == 0) {
            throw new Exception("Class name length must be greater than 0.");
        }
        
        $this->className = $className;
        $this->permissionLevel = $permissionLevel;
    }
    
    public function getClassInstance() {
        $instance = new $this->className($this->permissionLevel);
        
        if(!($instance instanceof IAction)) {
            throw new InvalidArgumentException("Class type passed into constructor does not implement IAction");
        }
        
        return $instance;
    }

}